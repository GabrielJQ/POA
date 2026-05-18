<?php

namespace App\Application\UseCases\POA;

use App\Domain\ValueObjects\FiltrosPOA;
use App\Domain\Contracts\IPOADomainService;
use App\Models\Almacen;
use Illuminate\Support\Facades\Cache;

class ObtenerDatosPOA
{
    private IPOADomainService $domainService;

    public function __construct(IPOADomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    public function execute(array $request): array
    {
        $filtros = FiltrosPOA::createFromRequest($request);

        $result = $this->domainService->obtenerDatosPOA($filtros);
        $compromisos = $result['compromisos'];
        $dataPoa = $result['dataPoa'];
        $almacenes = Cache::remember('almacenes_ordenados', 86400, fn() =>
            Almacen::orderBy('nombre')->get()
        );

        return [
            'compromisos' => $compromisos,
            'dataPoa' => $dataPoa,
            'almacenes' => $almacenes,
            'filtros' => $filtros,
            'anioSeleccionado' => $filtros->getAnio(),
            'almacenSeleccionado' => $filtros->getAlmacenId(),
            'mesActual' => $filtros->getPeriodo()->getMeses()[0] ?? 1,
            'trimestreSeleccionado' => 1,
            'periodoTipo' => $filtros->getPeriodo()->getTipo(),
            'mostrarConsolidado' => $filtros->isConsolidado(),
            'labelPeriodo' => $filtros->getPeriodo()->getLabel(),
            'meses' => \App\Domain\ValueObjects\Periodo::NOMBRES_MESES,
            'trimestres' => \App\Domain\ValueObjects\Periodo::NOMBRES_TRIMESTRES,
            'config' => [
                'meses' => $filtros->getPeriodo()->getMeses(),
                'nombre' => $filtros->getPeriodo()->getTipo(),
            ],
        ];
    }

    public function executeParaVista(array $request): array
    {
        $filtros = FiltrosPOA::createFromRequest($request);

        $result = $this->domainService->obtenerDatosPOA($filtros);
        $compromisos = $result['compromisos'];
        $dataPoa = $result['dataPoa'];

        return [
            'compromisos' => $compromisos,
            'dataPoa' => $dataPoa,
            'periodoTipo' => $filtros->getPeriodo()->getTipo(),
            'labelPeriodo' => $filtros->getPeriodo()->getLabel(),
            'config' => [
                'meses' => $filtros->getPeriodo()->getMeses(),
                'nombre' => $filtros->getPeriodo()->getTipo(),
            ],
            'meses' => \App\Domain\ValueObjects\Periodo::NOMBRES_MESES,
            'trimestres' => \App\Domain\ValueObjects\Periodo::NOMBRES_TRIMESTRES,
        ];
    }

}
