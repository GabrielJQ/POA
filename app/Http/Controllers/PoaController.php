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

        $anioSeleccionado = (int) $request->input('anio', date('Y'));
        $almacenSeleccionado = $request->input('almacen_id');
        $mesActual = (int) $request->input('mes', (int) date('m'));
        $trimestreSeleccionado = (int) $request->input('trimestre', ceil($mesActual / 3));
        $periodoTipo = $request->input('periodo', 'mensual');
        $mostrarConsolidado = $request->input('consolidado', 'si') === 'si';

        $configPeriodos = [
            'mensual' => [
                'nombre' => 'Mensual',
                'meses' => [],
            ],
            'trimestral' => [
                'nombre' => 'Trimestral',
                'meses' => $this->getMesesTrimestre($trimestreSeleccionado),
            ],
            'anual' => [
                'nombre' => 'Anual',
                'meses' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            ],
        ];

        $config = $configPeriodos[$periodoTipo] ?? $configPeriodos['mensual'];
        $labelPeriodo = $config['nombre'];

        if ($periodoTipo === 'mensual') {
            $config['meses'] = [$mesActual];
            $labelPeriodo = $config['nombre'] . ' - ' . ($this->mesesNombres()[$mesActual] ?? '');
        } elseif ($periodoTipo === 'trimestral') {
            $labelPeriodo = $config['nombre'] . ' T' . $trimestreSeleccionado;
        }

        $compromisos = CompromisoPoa::orderBy('orden')->get();

        if ($mostrarConsolidado) {
            $dataPoa = $this->buildDataConsolidado($compromisos, $anioSeleccionado, $config['meses']);
        } else {
            $query = PoaRegistro::where('anio', $anioSeleccionado)
                ->with(['compromiso', 'almacen']);

            if ($almacenSeleccionado) {
                $query->where('almacen_id', $almacenSeleccionado);
            }

            $registrosRaw = $query->get();
            $dataPoa = $this->buildDataPoa($registrosRaw);
        }

        $meses = $this->mesesNombres();
        $trimestres = [
            1 => 'ENE-MAR',
            2 => 'ABR-JUN',
            3 => 'JUL-SEP',
            4 => 'OCT-DIC',
        ];

        if ($request->ajax() === true || $request->expectsJson()) {
            return view('poa._tabla', compact(
                'compromisos',
                'dataPoa',
                'periodoTipo',
                'labelPeriodo',
                'config',
                'meses'
            ))->render();
        }

        return view('poa.index', compact(
            'compromisos',
            'dataPoa',
            'almacenes',
            'anioSeleccionado',
            'almacenSeleccionado',
            'mesActual',
            'trimestreSeleccionado',
            'periodoTipo',
            'mostrarConsolidado',
            'meses',
            'trimestres',
            'labelPeriodo',
            'config'
        ));
    }

    private function getMesesTrimestre(int $trimestre): array
    {
        return match ($trimestre) {
            1 => [1, 2, 3],
            2 => [4, 5, 6],
            3 => [7, 8, 9],
            4 => [10, 11, 12],
            default => [1, 2, 3],
        };
    }

    private function mesesNombres(): array
    {
        return [
            1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL',
            5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO',
            9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE',
        ];
    }

    private function buildDataPoa($registrosRaw): array
    {
        $dataPoa = [];
        foreach ($registrosRaw as $reg) {
            $dataPoa[$reg->compromiso_poa_id][$reg->tipo_registro] = $reg;
        }
        return $dataPoa;
    }

    private function buildDataConsolidado($compromisos, int $anio, array $meses): array
    {
        $compromisosIds = $compromisos->pluck('id')->toArray();
        
        $query = PoaRegistro::where('anio', $anio)
            ->whereIn('compromiso_poa_id', $compromisosIds);

        $registros = $query->get();

        $dataPoa = [];
        foreach ($compromisos as $compromiso) {
            $filas1 = $registros->where('compromiso_poa_id', $compromiso->id)
                ->where('tipo_registro', $compromiso->label_fila_1);
            $filas2 = $registros->where('compromiso_poa_id', $compromiso->id)
                ->where('tipo_registro', $compromiso->label_fila_2);

            // Sumar meta_anual de todos los registros COMPROMETIDOS
            $metaAnual1 = $filas1->sum('meta_anual');
            // Sumar meta_anual de todos los registros REALIZADOS  
            $metaAnual2 = $filas2->sum('meta_anual');

            // Siempre crear el objeto aunque sea 0
            $obj1 = new \stdClass();
            $obj1->meta_anual = $metaAnual1;
            
            // Sumar cada mes de todos los registros COMPROMETIDOS
            foreach ($meses as $mes) {
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $suma = 0;
                foreach ($filas1 as $fila) {
                    $suma += (float) ($fila->$col ?? 0);
                }
                $obj1->$col = $suma;
            }

            // Crear objeto para REALIZADOS (puede estar vacío)
            $obj2 = new \stdClass();
            $obj2->meta_anual = $metaAnual2;
            foreach ($meses as $mes) {
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $suma = 0;
                foreach ($filas2 as $fila) {
                    $suma += (float) ($fila->$col ?? 0);
                }
                $obj2->$col = $suma;
            }

            // Siempre guardar, aunque los datos sean 0
            $dataPoa[$compromiso->id][$compromiso->label_fila_1] = $obj1;
            $dataPoa[$compromiso->id][$compromiso->label_fila_2] = $obj2;
        }

        return $dataPoa;
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

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => $mensaje, 'success' => true]);
            }

            return redirect()->route('poa.index', [
                'anio' => $anio,
                'almacen_id' => $almacenId,
            ])->with('success', $mensaje);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => $e->getMessage(), 'success' => false], 500);
            }
            return redirect()->back()
                ->with('error', 'Error al sincronizar: ' . $e->getMessage());
        }
    }
}
