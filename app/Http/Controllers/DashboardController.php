<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\CompromisoPoa;
use App\Models\PoaRegistro;
use App\Models\ResultadoMensual;
use App\Models\Regional;
use App\Models\UnidadOperativa;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $anioActual = (int) date('Y');
        $mesActual = (int) date('m');

        $totalAlmacenes = Almacen::count();
        $totalRegionales = Regional::count();
        $totalUnidades = UnidadOperativa::count();

        $registrosER = ResultadoMensual::where('anio', $anioActual)->count();
        $registrosPOA = PoaRegistro::where('anio', $anioActual)->count();

        $compromisosActivos = CompromisoPoa::count();

        $dataER = ResultadoMensual::where('anio', $anioActual)
            ->selectRaw('SUM(monto) as monto_total, mes')
            ->groupBy('mes')
            ->pluck('monto_total', 'mes');

        $dataPOA = PoaRegistro::where('anio', $anioActual)
            ->selectRaw('SUM(meta_anual) as meta_total')
            ->value('meta_total') ?? 0;

        $porAlmacen = ResultadoMensual::where('anio', $anioActual)
            ->where('mes', $mesActual)
            ->join('almacenes', 'resultados_mensuales.almacen_id', '=', 'almacenes.id')
            ->selectRaw('almacenes.nombre as nombre, SUM(resultados_mensuales.monto) as monto')
            ->groupBy('almacenes.id', 'almacenes.nombre')
            ->orderByDesc('monto')
            ->limit(5)
            ->get();

        $porConceptoER = ResultadoMensual::where('anio', $anioActual)
            ->where('mes', $mesActual)
            ->join('conceptos_er', 'resultados_mensuales.concepto_er_id', '=', 'conceptos_er.id')
            ->selectRaw('conceptos_er.nombre as nombre, SUM(resultados_mensuales.monto) as monto')
            ->groupBy('conceptos_er.id', 'conceptos_er.nombre')
            ->orderByDesc('monto')
            ->limit(5)
            ->get();

        $porcentajeCumplimiento = $dataPOA > 0 && $dataER->sum('monto_total') > 0
            ? ($dataER->sum('monto_total') / $dataPOA) * 100
            : 0;

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
            'anioActual',
            'mesActual',
            'meses'
        ));
    }
}