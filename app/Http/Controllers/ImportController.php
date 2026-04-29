<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ERImport;
use App\Imports\VentasDetalladasImport;
use App\Models\Almacen;
use App\Domain\Services\PDFERExtractorService;
use Exception;
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
        $almacenes = Almacen::orderBy('nombre')->get();
        return view('importaciones.index', compact('almacenes'));
    }

    public function importER(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $anio = (int) $request->anio;
            $archivo = $request->file('archivo');

            // Obtener nombres reales de las pestañas
            $spreadsheet = IOFactory::load($archivo->getRealPath());
            $sheetNames = $spreadsheet->getSheetNames();
            
            // Cargamos los datos de todas las hojas
            $sheetsData = Excel::toArray(new \stdClass(), $archivo);
            $totalRegistros = 0;

            foreach ($sheetsData as $index => $rows) {
                $actualSheetName = $sheetNames[$index] ?? '';
                $sheetImport = new \App\Imports\ERSheetImport($anio, $actualSheetName);
                $registros = $sheetImport->import($rows);
                if ($registros > 0) {
                    $totalRegistros += $registros;
                }
            }

            if ($totalRegistros === 0) {
                throw new Exception("No se encontraron datos válidos en las hojas del archivo. Asegúrate de que el formato sea correcto.");
            }

            return redirect()->route('importaciones.index')
                ->with('success', "Estado de Resultados importado para {$anio}. Se procesaron múltiples almacenes correctamente.");
        } catch (Exception $e) {
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function importVentas(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv',
            'programa' => 'required|in:PAR,PE',
        ]);

        try {
            $archivo = $request->file('archivo');
            $programa = $request->programa;

            $import = new VentasDetalladasImport($programa);
            Excel::import($import, $archivo);
            
            return redirect()->route('importaciones.index')
                ->with('success', "Ventas del programa {$programa} importadas correctamente.");
        } catch (Exception $e) {
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar ventas: ' . $e->getMessage());
        }
    }

    public function importPDFRealizado(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:pdf',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $result = $this->pdfService->extract(
                $request->file('archivo')->getRealPath(),
                (int) $request->anio
            );

            return redirect()->route('importaciones.index')
                ->with('success', "PDF procesado con éxito para el mes " . $result['mes'] . ". Se actualizaron los datos reales de Ayutla.");
        } catch (Exception $e) {
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al procesar PDF: ' . $e->getMessage());
        }
    }
}