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
            ->selectRaw('SUM(monto) as monto_total, mes')
            ->groupBy('mes')
            ->pluck('monto_total', 'mes');

        $dataPOA = RegistroFinanciero::where('anio', $anioActual)
            ->where('tipo_dato', 'META')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'POA');
            })
            ->selectRaw('SUM(monto) as meta_total')
            ->value('meta_total') ?? 0;

        $porAlmacen = RegistroFinanciero::where('anio', $anioActual)
            ->where('mes', $mesActual)
            ->where('tipo_dato', 'REAL')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'ER');
            })
            ->join('almacenes', 'registros_financieros.almacen_id', '=', 'almacenes.id')
            ->selectRaw('almacenes.nombre as nombre, SUM(registros_financieros.monto) as monto')
            ->groupBy('almacenes.id', 'almacenes.nombre')
            ->orderByDesc('monto')
            ->limit(5)
            ->get();

        $porConceptoER = RegistroFinanciero::where('anio', $anioActual)
            ->where('mes', $mesActual)
            ->where('tipo_dato', 'REAL')
            ->whereHas('concepto', function ($q) {
                $q->where('categoria', 'ER');
            })
            ->join('conceptos_maestros', 'registros_financieros.concepto_id', '=', 'conceptos_maestros.id')
            ->selectRaw('conceptos_maestros.nombre as nombre, SUM(registros_financieros.monto) as monto')
            ->groupBy('conceptos_maestros.id', 'conceptos_maestros.nombre')
            ->orderByDesc('monto')
            ->limit(5)
            ->get();

        $porcentajeCumplimiento = $dataPOA > 0 && $dataER->sum() > 0
            ? ($dataER->sum() / $dataPOA) * 100
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