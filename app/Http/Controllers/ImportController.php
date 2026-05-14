<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ERImport;
use App\Imports\VentasDetalladasImport;
use App\Imports\SurtimientoTiendasImport;
use App\Imports\MermasQuebrantosImport;
use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use App\Domain\Services\PDFERExtractorService;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    private PDFERExtractorService $pdfService;

    public function __construct(PDFERExtractorService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Mostrar centro de importación
     *
     * Renderiza la página principal con todos los formularios de importación:
     * comprometidos (ER, Mermas) y realizados (Ventas, PDF, Surtimiento, Mermas).
     *
     * @group Importaciones
     */
    public function index()
    {
        $almacenes = Cache::remember('almacenes_ordenados', 86400, fn() =>
            Almacen::orderBy('nombre')->get()
        );
        return view('importaciones.index', compact('almacenes'));
    }

    /**
     * Importar Estado de Resultados (Excel)
     *
     * Procesa un archivo Excel con múltiples hojas (una por almacén) y
     * guarda/actualiza los registros META de la categoría ER.
     * Cada hoja se procesa con ERSheetImport.
     *
     * @group Importaciones
     *
     * @bodyParam archivo file required Archivo Excel (.xlsx, .xls, .csv) hasta 100MB.
     * @bodyParam anio int required Año de los registros (2000-2100).
     */
    public function importER(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv|max:102400',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $anio = (int) $request->anio;
            $archivo = $request->file('archivo');

            // Carga única del libro completo
            $reader = IOFactory::createReaderForFile($archivo->getRealPath());
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($archivo->getRealPath());
            $sheetNames = $spreadsheet->getSheetNames();
            $totalRegistros = 0;

            foreach ($sheetNames as $index => $actualSheetName) {
                $sheet = $spreadsheet->getSheet($index);
                $rows = $sheet->toArray();
                $sheetImport = new \App\Imports\ERSheetImport($anio, $actualSheetName);
                $registros = $sheetImport->import($rows);
                if ($registros > 0) {
                    $totalRegistros += $registros;
                }
            }
            $spreadsheet->disconnectWorksheets();

            if ($totalRegistros === 0) {
                throw new Exception("No se encontraron datos válidos en las hojas del archivo. Asegúrate de que el formato sea correcto.");
            }

            $this->invalidateCache();
            Log::info("[ImportController] ER importado para {$anio}: {$totalRegistros} registros totales.");
            return redirect()->route('importaciones.index')
                ->with('success', "Estado de Resultados importado para {$anio}. Se procesaron múltiples almacenes correctamente.");
        } catch (Exception $e) {
            Log::error("[ImportController] Error al importar ER: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    /**
     * Importar ventas detalladas (Excel)
     *
     * Procesa un Excel con ventas detalladas por línea de producto y almacén.
     * Soporta dos programas: PAR (Abasto Rural) y PE (Programa Especial).
     * Los datos se guardan como tipo_dato=REAL con programa=PAR|PE.
     *
     * @group Importaciones
     *
     * @bodyParam archivo file required Archivo Excel (.xlsx, .xls, .csv) hasta 100MB.
     * @bodyParam programa string Programa: "PAR" para Abasto Rural, "PE" para Programa Especial.
     */
    public function importVentas(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv|max:102400',
            'programa' => 'nullable|in:PAR,PE',
        ]);

        try {
            $archivo = $request->file('archivo');
            $programa = $request->programa ?? 'PAR';

            $import = new \App\Imports\VentasDetalladasImport($programa);
            $totalRegistros = $import->import($archivo->getRealPath());

            $this->invalidateCache();
            Log::info("[ImportController] Ventas importadas: {$totalRegistros} registros ({$programa}).");
            return back()->with('success', "Se han importado {$totalRegistros} registros de ventas ({$programa}) correctamente.");
        } catch (Exception $e) {
            Log::error("[ImportController] Error al importar ventas: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar ventas: ' . $e->getMessage());
        }
    }

    /**
     * Importar surtimiento a tiendas (Excel)
     *
     * Procesa el archivo "CONS 2026.xlsx" con columnas de Oportunidad y Eficiencia
     * por trimestre (Q1-Q4). Distribuye el valor trimestral en 3 meses.
     * Guarda registros REAL para los conceptos de Oportunidad y Eficiencia de Surtimiento.
     *
     * @group Importaciones
     *
     * @bodyParam archivo file required Archivo Excel (.xlsx, .xls) hasta 100MB.
     * @bodyParam anio int required Año de los registros (2000-2100).
     */
    public function importSurtimiento(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls|max:102400',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $anio = (int) $request->anio;
            $import = new SurtimientoTiendasImport();
            $count = $import->import($request->file('archivo')->getRealPath(), $anio);

            $this->invalidateCache();
            Log::info("[ImportController] Surtimiento importado para {$anio}: {$count} registros.");
            return redirect()->route('importaciones.index')
                ->with('success', "Surtimiento a tiendas importado para {$anio}. {$count} registros REALES guardados.");
        } catch (Exception $e) {
            Log::error("[ImportController] Error al importar surtimiento: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar surtimiento: ' . $e->getMessage());
        }
    }

    /**
     * Importar mermas y quebrantos (Excel)
     *
     * Procesa Excel con pestañas por almacén (ej. "PT AYUTLA").
     * Calcula el monto comprometido (META) aplicando tasas de merma+quebranto
     * sobre las ventas de cada línea de producto (config/mermas.php).
     *
     * @group Importaciones
     *
     * @bodyParam archivo file required Archivo Excel (.xlsx, .xls) hasta 100MB.
     * @bodyParam anio int required Año de los registros (2000-2100).
     */
    public function importMermas(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls|max:102400',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $anio = (int) $request->anio;
            $import = new MermasQuebrantosImport();
            $count = $import->import($request->file('archivo')->getRealPath(), $anio);

            $this->invalidateCache();
            Log::info("[ImportController] Mermas importadas para {$anio}: {$count} registros.");
            return redirect()->route('importaciones.index')
                ->with('success', "Mermas, Quebrantos y Mal Estado importados para {$anio}. {$count} registros COMPROMETIDO guardados.");
        } catch (Exception $e) {
            Log::error("[ImportController] Error al importar mermas: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar mermas: ' . $e->getMessage());
        }
    }

    /**
     * Guardar mermas realizadas (formulario manual)
     *
     * Registro manual de REALIZADO de Mermas, Quebrantos y Mal Estado.
     * Recibe un monto trimestral y lo distribuye uniformemente en 3 meses,
     * ajustando el último mes para cuadrar centavos.
     *
     * @group Importaciones
     *
     * @bodyParam almacen_id int required ID del almacén.
     * @bodyParam anio int required Año (2000-2100).
     * @bodyParam trimestre int required Trimestre (1-4).
     * @bodyParam monto numeric required Monto trimestral.
     */
    public function importMermasComprometido(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|integer|exists:almacenes,id',
            'anio' => 'required|integer|min:2000|max:2100',
            'trimestre' => 'required|integer|min:1|max:4',
            'monto' => 'required|numeric|min:0',
        ]);

        $concepto = ConceptoMaestro::where('nombre', 'MERMAS, QUEBRANTOS Y MAL ESTADO')
            ->where('categoria', 'POA')
            ->first();

        if (!$concepto) {
            return redirect()->route('importaciones.index')
                ->with('error', 'Concepto MERMAS, QUEBRANTOS Y MAL ESTADO no encontrado en la base de datos.');
        }

        $almacenId = (int) $request->almacen_id;
        $anio = (int) $request->anio;
        $trimestre = (int) $request->trimestre;
        $valor = (float) $request->monto;

        $mesesPorTrimestre = [
            1 => [1, 2, 3],
            2 => [4, 5, 6],
            3 => [7, 8, 9],
            4 => [10, 11, 12],
        ];

        $meses = $mesesPorTrimestre[$trimestre];
        $base = floor(($valor / 3) * 100 + 1e-9) / 100;
        $totalBase = $base * 3;
        $resto = round($valor - $totalBase, 2);

        foreach ($meses as $i => $mes) {
            $monto = $base + ($i === array_key_last($meses) ? $resto : 0);
            RegistroFinanciero::updateOrCreate(
                [
                    'almacen_id' => $almacenId,
                    'concepto_id' => $concepto->id,
                    'anio' => $anio,
                    'mes' => $mes,
                    'tipo_dato' => 'REAL',
                    'programa' => null,
                ],
                ['monto' => $monto]
            );
        }

        $this->invalidateCache();
        $almacen = Almacen::find($almacenId);
        Log::info("[ImportController] Mermas REAL guardado para {$almacen->nombre} {$anio}: 3 registros.");
        return redirect()->route('importaciones.index')
            ->with('success', "Realizado de Mermas guardado para {$almacen->nombre} ({$anio}) Trimestre {$trimestre}. 3 registros actualizados.");
    }

    /**
     * Importar realizado desde PDF
     *
     * Extrae datos reales de un PDF de Estado de Resultados.
     * Detecta automáticamente el mes y escala valores (miles → pesos).
     * Procesa dos bloques de tiendas y conceptos como TOTAL GTOS DE DISTRIBUCION
     * y RESULTADO DIRECTO DE OPERACIÓN.
     *
     * @group Importaciones
     *
     * @bodyParam archivo file required Archivo PDF hasta 100MB.
     * @bodyParam anio int required Año de los registros (2000-2100).
     */
    public function importPDFRealizado(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:102400',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $result = $this->pdfService->extract(
                $request->file('archivo')->getRealPath(),
                (int) $request->anio
            );

            $this->invalidateCache();
            return redirect()->route('importaciones.index')
                ->with('success', "PDF procesado con éxito para el mes " . $result['mes'] . ". Se actualizaron {$result['count']} registros REALES (" . implode(', ', $result['conceptos']) . ").");
        } catch (Exception $e) {
            Log::error("[ImportController] Error al procesar PDF: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al procesar PDF: ' . $e->getMessage());
        }
    }

    private function invalidateCache(): void
    {
        Cache::rememberForever('poa_cache_version', fn() => 0);
        Cache::increment('poa_cache_version');
    }
}