<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ERExport;
use App\Application\UseCases\ER\ObtenerDatosER;
use App\Application\UseCases\ER\ImportarER;
use App\Application\UseCases\ER\GuardarRegistroER;
use App\Domain\Contracts\IPDFERExtractorService;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class EstadoResultadosController extends Controller
{
    private ObtenerDatosER $obtenerDatosER;
    private ImportarER $importarER;
    private GuardarRegistroER $guardarRegistroER;
    private IPDFERExtractorService $pdfService;

    public function __construct(
        ObtenerDatosER $obtenerDatosER,
        ImportarER $importarER,
        GuardarRegistroER $guardarRegistroER,
        IPDFERExtractorService $pdfService
    ) {
        $this->obtenerDatosER = $obtenerDatosER;
        $this->importarER = $importarER;
        $this->guardarRegistroER = $guardarRegistroER;
        $this->pdfService = $pdfService;
    }

    /**
     * Mostrar Estado de Resultados
     *
     * Renderiza la tabla del Estado de Resultados con filtros por almacén y año.
     * Muestra los 12 meses con totales anuales para cada concepto ER.
     * Si la petición es AJAX, devuelve solo el HTML de la tabla.
     *
     * @group Estado de Resultados
     *
     * @queryParam anio int Año (default: año actual).
     * @queryParam almacen_id int ID del almacén (opcional, para vista individual).
     */
    public function index(Request $request)
    {
        $data = $this->obtenerDatosER->execute($request->all());

        if ($request->ajax() === true || $request->expectsJson()) {
            return view('components.estado_resultados.tabla', [
                'matriz' => $data['matriz'],
                'conceptos' => $data['conceptos'],
            ])->render();
        }

        return view('estado_resultados.index', $data);
    }

    /**
     * Exportar Estado de Resultados (Excel)
     *
     * Descarga la matriz del Estado de Resultados en formato Excel (.xlsx)
     * con todos los conceptos ER y sus valores mensuales.
     *
     * @group Estado de Resultados
     *
     * @queryParam anio int Año.
     * @queryParam almacen_id int ID del almacén (opcional).
     */
    public function export(Request $request)
    {
        $data = $this->obtenerDatosER->executeParaVista($request->all());

        $nombreArchivo = 'Estado_Resultados_' . $request->input('anio', date('Y')) 
            . ($request->input('almacen_id') ? '_Almacen_'.$request->input('almacen_id') : '_Consolidado') 
            . '.xlsx';

        return Excel::download(new ERExport($data['matriz'], $data['conceptos']), $nombreArchivo);
    }

    /**
     * Importar Estado de Resultados (Excel) - Use Case
     *
     * Procesa un Excel de Estado de Resultados utilizando el caso de uso ImportarER.
     * Similar a POST /importaciones/er pero desde la sección ER. Sincroniza
     * automáticamente las metas POA después de la importación.
     *
     * @group Estado de Resultados
     *
     * @bodyParam archivo_excel file required Archivo Excel (.xlsx, .xls, .csv) hasta 100MB.
     * @bodyParam anio int required Año (2000-2100).
     */
    public function import(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,xls,csv|max:102400',
            'anio' => 'required|integer|min:2000|max:2100'
        ]);

        try {
            $result = $this->importarER->execute(
                (int) $request->anio,
                $request->file('archivo_excel')
            );

            return redirect()->route('estado-resultados.index')
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            Log::error("[ER] Error importación Excel: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    /**
     * Guardar registro ER manual
     *
     * Guarda un registro individual en el Estado de Resultados.
     * Útil para captura manual de datos cuando no se dispone de archivo.
     *
     * @group Estado de Resultados
     *
     * @bodyParam almacen_id int required ID del almacén.
     * @bodyParam concepto_id int required ID del concepto maestro (categoría ER).
     * @bodyParam anio int required Año (2000-2100).
     * @bodyParam mes int required Mes (1-12).
     * @bodyParam monto numeric required Monto del registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'concepto_id' => 'required|exists:conceptos_maestros,id',
            'anio' => 'required|integer|min:2000|max:2100',
            'mes' => 'required|integer|between:1,12',
            'monto' => 'required|numeric'
        ]);

        $this->guardarRegistroER->execute($request->all());

        return redirect()->route('estado-resultados.index')
            ->with('success', 'Registro guardado exitosamente.');
    }

    /**
     * Importar Estado de Resultados desde PDF
     *
     * Procesa un PDF de Estado de Resultados, extrayendo valores reales
     * para los conceptos TOTAL GTOS DE DISTRIBUCION y RESULTADO DIRECTO DE OPERACIÓN.
     * Detecta automáticamente el mes y almacén.
     *
     * @group Estado de Resultados
     *
     * @bodyParam archivo_pdf file required Archivo PDF hasta 100MB.
     * @bodyParam anio int required Año (2000-2100).
     */
    public function importPDF(Request $request)
    {
        $request->validate([
            'archivo_pdf' => 'required|mimes:pdf|max:102400',
            'anio' => 'required|integer|min:2000|max:2100'
        ]);

        try {
            $result = $this->pdfService->extract(
                $request->file('archivo_pdf')->getRealPath(),
                (int) $request->anio
            );

            return redirect()->route('estado-resultados.index')
                ->with('success', "PDF procesado con éxito para el mes " . $result['mes'] . ". Se actualizaron " . $result['count'] . " conceptos.");
        } catch (\Exception $e) {
            Log::error("[ER] Error al procesar PDF: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->with('error', 'Error al procesar PDF: ' . $e->getMessage());
        }
    }
}