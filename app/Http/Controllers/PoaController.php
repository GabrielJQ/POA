<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\POA\ObtenerDatosPOA;
use App\Application\UseCases\POA\SincronizarPOA;
use App\Models\Almacen;

class PoaController extends Controller
{
    private ObtenerDatosPOA $obtenerDatosPOA;
    private SincronizarPOA $sincronizarPOA;

    public function __construct(
        ObtenerDatosPOA $obtenerDatosPOA,
        SincronizarPOA $sincronizarPOA
    ) {
        $this->obtenerDatosPOA = $obtenerDatosPOA;
        $this->sincronizarPOA = $sincronizarPOA;
    }

    public function index(Request $request)
    {
        $data = $this->obtenerDatosPOA->execute($request->all());

        if ($request->ajax() === true || $request->expectsJson()) {
            return view('poa._tabla', [
                'compromisos' => $data['compromisos'],
                'dataPoa' => $data['dataPoa'],
                'periodoTipo' => $data['periodoTipo'],
                'labelPeriodo' => $data['labelPeriodo'],
                'config' => $data['config'],
                'meses' => $data['meses'],
            ])->render();
        }

        $almacenes = Almacen::orderBy('nombre')->get();

        return view('poa.index', array_merge($data, [
            'almacenes' => $almacenes,
            'trimestres' => [
                1 => 'ENE-MAR', 2 => 'ABR-JUN', 3 => 'JUL-SEP', 4 => 'OCT-DIC',
            ],
        ]));
    }

    public function sync(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        $anio = (int) $request->anio;
        $almacenId = $request->input('almacen_id');

        try {
            $result = $this->sincronizarPOA->execute($anio, $almacenId ? (int) $almacenId : null);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => $result['message'], 'success' => true]);
            }

            return redirect()->route('poa.index', [
                'anio' => $anio,
                'almacen_id' => $almacenId,
            ])->with('success', $result['message']);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => $e->getMessage(), 'success' => false], 500);
            }
            return redirect()->back()
                ->with('error', 'Error al sincronizar: ' . $e->getMessage());
        }
    }
}