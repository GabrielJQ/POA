<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\ConceptoER;
use App\Models\ResultadoMensual;
use App\Imports\ERImport;
use App\Exports\ERExport;
use App\Services\POAService;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class EstadoResultadosController extends Controller
{
    protected POAService $poaService;

    public function __construct(POAService $poaService)
    {
        $this->poaService = $poaService;
    }

    /**
     * Muestra la vista principal con tabla de resultados y formularios.
     */
    public function index(Request $request)
    {
        $almacenes = Almacen::all();
        // Traer conceptos ordenados como en el Excel
        $conceptos = ConceptoER::orderBy('orden_visual', 'asc')->get();
        
        $query = ResultadoMensual::query();

        // Filtros (Por defecto mostramos el año actual y todos los almacenes si no hay filtro, 
        // o podemos forzar seleccionar uno)
        $anioSeleccionado = $request->input('anio', date('Y'));
        $almacenSeleccionado = $request->input('almacen_id');

        $query->where('anio', $anioSeleccionado);

        if ($almacenSeleccionado) {
            $query->where('almacen_id', $almacenSeleccionado);
        }

        // Obtenemos todo sin paginar para armar la matriz (1 año = 1 vista)
        $resultadosRaw = $query->get();

        // Estructuramos en matriz: $matriz[concepto_id][mes] = monto
        $matriz = [];
        foreach ($resultadosRaw as $res) {
            if (!isset($matriz[$res->concepto_er_id])) {
                $matriz[$res->concepto_er_id] = array_fill(1, 12, 0);
            }
            $matriz[$res->concepto_er_id][$res->mes] += $res->monto;
        }

        if ($request->ajax() === true) {
            return view('estado_resultados._tabla', compact('matriz', 'conceptos'))->render();
        }

        return view('estado_resultados.index', compact('matriz', 'conceptos', 'almacenes', 'almacenSeleccionado', 'anioSeleccionado'));
    }

    /**
     * Exporta la vista actual a Excel
     */
    public function export(Request $request)
    {
        $conceptos = ConceptoER::orderBy('orden_visual', 'asc')->get();
        $query = ResultadoMensual::query();

        $anioSeleccionado = $request->input('anio', date('Y'));
        $almacenSeleccionado = $request->input('almacen_id');

        $query->where('anio', $anioSeleccionado);
        if ($almacenSeleccionado) {
            $query->where('almacen_id', $almacenSeleccionado);
        }

        $resultadosRaw = $query->get();
        $matriz = [];
        foreach ($resultadosRaw as $res) {
            if (!isset($matriz[$res->concepto_er_id])) {
                $matriz[$res->concepto_er_id] = array_fill(1, 12, 0);
            }
            $matriz[$res->concepto_er_id][$res->mes] += $res->monto;
        }

        $nombreArchivo = 'Estado_Resultados_' . $anioSeleccionado . ($almacenSeleccionado ? '_Almacen_'.$almacenSeleccionado : '_Consolidado') . '.xlsx';
        
        return Excel::download(new \App\Exports\ERExport($matriz, $conceptos), $nombreArchivo);
    }

    /**
     * Procesa la carga masiva desde un archivo Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,xls,csv',
            'anio' => 'required|integer|min:2000|max:2100'
        ]);

        try {
            // Importar usando el archivo subido y el año definido
            Excel::import(new ERImport($request->anio), $request->file('archivo_excel'));

            // Sincronizar automáticamente las metas comprometidas del POA
            // Buscamos todos los almacenes que tienen datos para este año
            $almacenesAfectados = ResultadoMensual::where('anio', $request->anio)
                ->distinct()
                ->pluck('almacen_id');

            foreach ($almacenesAfectados as $almacenId) {
                $this->poaService->syncFromER($almacenId, (int) $request->anio);
            }
            
            return redirect()->route('estado-resultados.index')
                             ->with('success', 'Archivo importado y metas POA sincronizadas correctamente.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    /**
     * Permite guardar (o actualizar) un solo registro manual.
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'concepto_er_id' => 'required|exists:conceptos_er,id',
            'anio' => 'required|integer|min:2000|max:2100',
            'mes' => 'required|integer|between:1,12',
            'monto' => 'required|numeric'
        ]);

        // Evitar duplicados con updateOrCreate
        ResultadoMensual::updateOrCreate(
            [
                'almacen_id' => $request->almacen_id,
                'concepto_er_id' => $request->concepto_er_id,
                'anio' => $request->anio,
                'mes' => $request->mes,
            ],
            [
                'monto' => $request->monto
            ]
        );

        return redirect()->route('estado-resultados.index')
                         ->with('success', 'Registro guardado exitosamente.');
    }
}
