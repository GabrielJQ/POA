<?php

namespace App\Application\UseCases\POA;

use App\Domain\ValueObjects\FiltrosPOA;
use App\Domain\Contracts\IPOADomainService;
use App\Domain\Contracts\Repositories\IAlmacenRepository;

class ObtenerDatosPOA
{
    private IPOADomainService $domainService;
    private IAlmacenRepository $almacenRepo;

    public function __construct(IPOADomainService $domainService, IAlmacenRepository $almacenRepo)
    {
        $this->domainService = $domainService;
        $this->almacenRepo = $almacenRepo;
    }

    public function execute(array $request): array
    {
        $filtros = FiltrosPOA::createFromRequest($request);

        $result = $this->domainService->obtenerDatosPOA($filtros);
        $compromisos = $result['compromisos'];
        $dataPoa = $result['dataPoa'];
        $almacenes = $this->almacenRepo->findAllOrdered();

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
