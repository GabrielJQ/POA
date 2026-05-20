<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Contracts\IDashboardService;
use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\IPOADomainService;
use App\Domain\ValueObjects\FiltrosPOA;
use App\Domain\ValueObjects\Periodo;

class DashboardController extends Controller
{
    public function __construct(
        private IDashboardService $dashboardService,
        private IAlmacenRepository $almacenRepo,
        private IPOADomainService $poaDomainService,
    ) {}

    public function index()
    {
        $user = auth()->user();

        if ($user->isCapturista()) {
            return $this->capturistaHome($user);
        }

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

    private function capturistaHome($user): \Illuminate\View\View
    {
        $almacen = $user->almacen;
        $anio = (int) date('Y');

        $filtros = new FiltrosPOA(
            anio: $anio,
            almacenId: $almacen->id,
            consolidado: false,
            periodo: new Periodo(Periodo::ANUAL)
        );

        $poaData = $this->poaDomainService->obtenerDatosPOA($filtros);

        return view('capturista.dashboard', [
            'almacen' => $almacen,
            'anio' => $anio,
            'poaData' => $poaData,
        ]);
    }
}
