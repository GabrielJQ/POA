<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\CompromisoPoa;
use App\Models\PoaRegistro;
use App\Services\POAService;

class PoaController extends Controller
{
    protected POAService $poaService;

    public function __construct(POAService $poaService)
    {
        $this->poaService = $poaService;
    }

    /**
     * Muestra la vista principal del Programa Anual de Trabajo (POA).
     */
    public function index(Request $request)
    {
        $almacenes = Almacen::orderBy('nombre')->get();

        $anioSeleccionado = $request->input('anio', date('Y'));
        $almacenSeleccionado = $request->input('almacen_id');
        $mesActual = $request->input('mes', (int) date('m'));

        // Compromisos ordenados
        $compromisos = CompromisoPoa::orderBy('orden')->get();

        // Registros POA filtrados
        $query = PoaRegistro::where('anio', $anioSeleccionado)
            ->with(['compromiso', 'almacen']);

        if ($almacenSeleccionado) {
            $query->where('almacen_id', $almacenSeleccionado);
        }

        $registrosRaw = $query->get();

        // Estructurar: $dataPoa[compromiso_id][tipo_registro] = PoaRegistro
        $dataPoa = [];
        foreach ($registrosRaw as $reg) {
            $dataPoa[$reg->compromiso_poa_id][$reg->tipo_registro] = $reg;
        }

        // Nombres de meses en español
        $meses = [
            1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL',
            5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO',
            9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE',
        ];

        if ($request->ajax()) {
            return view('poa._tabla', compact('compromisos', 'dataPoa', 'mesActual', 'meses'))->render();
        }

        return view('poa.index', compact(
            'compromisos',
            'dataPoa',
            'almacenes',
            'anioSeleccionado',
            'almacenSeleccionado',
            'mesActual',
            'meses'
        ));
    }

    /**
     * Fuerza la re-sincronización manual de las metas POA desde el ER.
     */
    public function sync(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        $anio = (int) $request->anio;
        $almacenId = $request->input('almacen_id');

        try {
            if ($almacenId) {
                $count = $this->poaService->syncFromER((int) $almacenId, $anio);
                $mensaje = "Metas POA sincronizadas ({$count} compromisos actualizados).";
            } else {
                $almacenes = Almacen::whereHas('resultadosMensuales', function ($q) use ($anio) {
                    $q->where('anio', $anio);
                })->pluck('id');

                $totalCount = 0;
                foreach ($almacenes as $id) {
                    $totalCount += $this->poaService->syncFromER($id, $anio);
                }
                $mensaje = "Metas POA sincronizadas para {$almacenes->count()} almacén(es), {$totalCount} compromisos actualizados.";
            }

            return redirect()->route('poa.index', [
                'anio' => $anio,
                'almacen_id' => $almacenId,
            ])->with('success', $mensaje);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al sincronizar: ' . $e->getMessage());
        }
    }
}
