<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ERImport;
use App\Imports\VentasDetalladasImport;
use App\Imports\SurtimientoTiendasImport;
use App\Imports\MermasQuebrantosImport;
use App\Models\Almacen;
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

    public function index()
    {
        $almacenes = Cache::remember('almacenes_ordenados', 86400, fn() =>
            Almacen::orderBy('nombre')->get()
        );
        return view('importaciones.index', compact('almacenes'));
    }

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