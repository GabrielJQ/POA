<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ERImport;
use App\Domain\Entities\Almacen;
use App\Domain\Entities\ConceptoMaestro;
use App\Domain\Entities\RegistroFinanciero;
use App\Domain\Contracts\ICacheStore;
use App\Domain\Contracts\IPDFERExtractorService;
use App\Domain\Shared\CacheKeys;
use App\Application\UseCases\POA\ImportarSurtimiento;
use App\Application\UseCases\POA\ImportarAperturaTiendas;
use App\Application\UseCases\POA\ImportarMermas;
use App\Application\UseCases\POA\ImportarVentasDetalladas;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    private IPDFERExtractorService $pdfService;
    private ImportarSurtimiento $importarSurtimiento;
    private ImportarAperturaTiendas $importarAperturaTiendas;
    private ImportarMermas $importarMermas;
    private ImportarVentasDetalladas $importarVentasDetalladas;
    private ICacheStore $cache;

    public function __construct(
        IPDFERExtractorService $pdfService,
        ImportarSurtimiento $importarSurtimiento,
        ImportarAperturaTiendas $importarAperturaTiendas,
        ImportarMermas $importarMermas,
        ImportarVentasDetalladas $importarVentasDetalladas,
        ICacheStore $cache
    ) {
        $this->pdfService = $pdfService;
        $this->importarSurtimiento = $importarSurtimiento;
        $this->importarAperturaTiendas = $importarAperturaTiendas;
        $this->importarMermas = $importarMermas;
        $this->importarVentasDetalladas = $importarVentasDetalladas;
        $this->cache = $cache;
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
        $user = auth()->user();

        $almacenes = Cache::remember(
            \App\Domain\Shared\CacheKeys::ALMACENES,
            86400,
            fn() =>
            Almacen::orderBy('nombre')->get()
        );

        if ($user->isCapturista()) {
            $almacenes = $almacenes->where('id', $user->almacen_id);
        }

        return view('importaciones.index', array_merge(
            compact('almacenes'),
            ['esCapturista' => $user->isCapturista()]
        ));
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

            // Carga única del libro completo mediante Maatwebsite Excel delegando a ERImport
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\ERImport($anio), $archivo);
            $totalRegistros = 1; // Indicador de éxito

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
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $result = $this->importarVentasDetalladas->execute(
                $request->file('archivo'),
                (int) $request->anio
            );

            Log::info("[ImportController] Ventas importadas.");
            return back()->with('success', $result['message']);
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
            $result = $this->importarSurtimiento->execute(
                $request->file('archivo'),
                (int) $request->anio
            );

            Log::info("[ImportController] Surtimiento importado.");
            return redirect()->route('importaciones.index')
                ->with('success', $result['message']);
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
            $result = $this->importarMermas->execute(
                $request->file('archivo'),
                (int) $request->anio
            );

            Log::info("[ImportController] Mermas importadas.");
            return redirect()->route('importaciones.index')
                ->with('success', $result['message']);
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
        $user = auth()->user();

        if ($user->isCapturista()) {
            $request->merge(['almacen_id' => $user->almacen_id]);
        }

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

    /**
     * Importar apertura de tiendas (Excel)
     *
     * @group Importaciones
     */
    public function importAperturaTiendas(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls|max:102400',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $result = $this->importarAperturaTiendas->execute(
                $request->file('archivo'),
                (int) $request->anio
            );

            Log::info("[ImportController] Apertura de tiendas importada.");
            return redirect()->route('importaciones.index')
                ->with('success', $result['message']);
        } catch (Exception $e) {
            Log::error("[ImportController] Error al importar apertura de tiendas: " . $e->getMessage());
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar apertura de tiendas: ' . $e->getMessage());
        }
    }

    private function invalidateCache(): void
    {
        $this->cache->increment(CacheKeys::POA_VERSION);
    }
}