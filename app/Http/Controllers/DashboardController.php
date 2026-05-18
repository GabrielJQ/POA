<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Contracts\IDashboardService;

class DashboardController extends Controller
{
    private IDashboardService $dashboardService;

    public function __construct(IDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Mostrar dashboard principal
     *
     * Renderiza el dashboard con indicadores de eficiencia por almacén:
     * índice consolidado, top/bottom 3 almacenes, semáforo de rendimiento.
     * Calcula el % de logro por concepto vs meta para cada almacén.
     *
     * @group Dashboard
     */
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
