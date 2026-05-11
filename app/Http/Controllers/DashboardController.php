<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\DashboardService;

class DashboardController extends Controller
{
    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $anioActual = (int) date('Y');
        $mesActual = (int) date('m');

        $data = $this->dashboardService->calcularEficiencia($anioActual);

        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];

        return view('dashboard.index', array_merge($data, [
            'anioActual' => $anioActual,
            'mesActual' => $mesActual,
            'meses' => $meses,
        ]));
    }
}
