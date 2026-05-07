<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use App\Models\Regional;
use App\Models\UnidadOperativa;

class DashboardController extends Controller
{
    public function index()
    {
        $anioActual = (int) date('Y');
        $mesActual = (int) date('m');

        $totalAlmacenes = Almacen::count();
        $totalRegionales = Regional::count();
        $totalUnidades = UnidadOperativa::count();

        $registrosER = RegistroFinanciero::where('anio', $anioActual)
            ->where('tipo_dato', 'REAL')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'ER');
            })->count();

        $registrosPOA = RegistroFinanciero::where('anio', $anioActual)
            ->whereIn('tipo_dato', ['META', 'PROYECTADO'])
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'POA');
            })->count();

        $compromisosActivos = ConceptoMaestro::where('categoria', 'POA')->count();

        $dataER = RegistroFinanciero::where('anio', $anioActual)
            ->where('tipo_dato', 'REAL')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'ER');
            })
            ->get()
            ->groupBy('mes')
            ->map(fn($group) => $group->sum('monto'));

        $dataPOA = RegistroFinanciero::where('anio', $anioActual)
            ->where('tipo_dato', 'META')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'POA');
            })
            ->get()
            ->sum('monto');

        $porAlmacen = RegistroFinanciero::where('anio', $anioActual)
            ->where('mes', $mesActual)
            ->where('tipo_dato', 'REAL')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'ER');
            })
            ->with('almacen')
            ->get()
            ->groupBy('almacen_id')
            ->map(function ($group) {
                return (object) [
                    'nombre' => $group->first()->almacen->nombre,
                    'monto' => $group->sum('monto')
                ];
            })
            ->sortByDesc('monto')
            ->take(5);

        $porConceptoER = RegistroFinanciero::where('anio', $anioActual)
            ->where('mes', $mesActual)
            ->where('tipo_dato', 'REAL')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'ER');
            })
            ->with('concepto')
            ->get()
            ->groupBy('concepto_id')
            ->map(function ($group) {
                return (object) [
                    'nombre' => $group->first()->concepto->nombre,
                    'monto' => $group->sum('monto')
                ];
            })
            ->sortByDesc('monto')
            ->take(5);

        $porcentajeCumplimiento = $dataPOA > 0 && $dataER->sum() > 0
            ? ($dataER->sum() / $dataPOA) * 100
            : 0;

        $evolucionMensual = RegistroFinanciero::where('anio', $anioActual)
            ->where('tipo_dato', 'REAL')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'ER');
            })
            ->get()
            ->groupBy(['concepto_id', 'mes'])
            ->map(function ($meses) {
                return $meses->map(fn($group) => $group->sum('monto'));
            });

        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];

        return view('dashboard.index', compact(
            'totalAlmacenes',
            'totalRegionales',
            'totalUnidades',
            'registrosER',
            'registrosPOA',
            'compromisosActivos',
            'dataER',
            'dataPOA',
            'porAlmacen',
            'porConceptoER',
            'porcentajeCumplimiento',
            'evolucionMensual',
            'anioActual',
            'mesActual',
            'meses'
        ));
    }
}