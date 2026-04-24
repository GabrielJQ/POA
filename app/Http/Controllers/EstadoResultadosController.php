<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\ER\ObtenerDatosER;
use App\Application\UseCases\ER\ImportarER;
use App\Application\UseCases\ER\GuardarRegistroER;
use App\Exports\ERExport;
use Maatwebsite\Excel\Facades\Excel;

class EstadoResultadosController extends Controller
{
    private ObtenerDatosER $obtenerDatosER;
    private ImportarER $importarER;
    private GuardarRegistroER $guardarRegistroER;

    public function __construct(
        ObtenerDatosER $obtenerDatosER,
        ImportarER $importarER,
        GuardarRegistroER $guardarRegistroER
    ) {
        $this->obtenerDatosER = $obtenerDatosER;
        $this->importarER = $importarER;
        $this->guardarRegistroER = $guardarRegistroER;
    }

    public function index(Request $request)
    {
        $data = $this->obtenerDatosER->execute($request->all());

        if ($request->ajax() === true || $request->expectsJson()) {
            return view('estado_resultados._tabla', [
                'matriz' => $data['matriz'],
                'conceptos' => $data['conceptos'],
            ])->render();
        }

        return view('estado_resultados.index', $data);
    }

    public function export(Request $request)
    {
        $data = $this->obtenerDatosER->executeParaVista($request->all());

        $nombreArchivo = 'Estado_Resultados_' . $request->input('anio', date('Y')) 
            . ($request->input('almacen_id') ? '_Almacen_'.$request->input('almacen_id') : '_Consolidado') 
            . '.xlsx';

        return Excel::download(new ERExport($data['matriz'], $data['conceptos']), $nombreArchivo);
    }

    public function import(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,xls,csv',
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
            return redirect()->back()
                ->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'concepto_er_id' => 'required|exists:conceptos_er,id',
            'anio' => 'required|integer|min:2000|max:2100',
            'mes' => 'required|integer|between:1,12',
            'monto' => 'required|numeric'
        ]);

        $this->guardarRegistroER->execute($request->all());

        return redirect()->route('estado-resultados.index')
            ->with('success', 'Registro guardado exitosamente.');
    }
}