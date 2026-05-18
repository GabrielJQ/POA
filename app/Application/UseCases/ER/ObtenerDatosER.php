<?php

namespace App\Application\UseCases\ER;

use App\Domain\ValueObjects\FiltrosER;
use App\Domain\Contracts\IERDomainService;
use App\Domain\Contracts\Repositories\IAlmacenRepository;

class ObtenerDatosER
{
    private IERDomainService $domainService;
    private IAlmacenRepository $almacenRepo;

    public function __construct(IERDomainService $domainService, IAlmacenRepository $almacenRepo)
    {
        $this->domainService = $domainService;
        $this->almacenRepo = $almacenRepo;
    }

    public function execute(array $request): array
    {
        $filtros = FiltrosER::createFromRequest($request);

        $conceptos = $this->domainService->obtenerConceptosER();
        $matriz = $this->domainService->obtenerDatosER($filtros);
        $almacenes = $this->almacenRepo->findAllOrdered();

        return [
            'conceptos' => $conceptos,
            'matriz' => $matriz,
            'almacenes' => $almacenes,
            'filtros' => $filtros,
            'anioSeleccionado' => $filtros->getAnio(),
            'almacenSeleccionado' => $filtros->getAlmacenId(),
            'mostrarConsolidado' => $filtros->isConsolidado(),
        ];
    }

    public function executeParaVista(array $request): array
    {
        $filtros = FiltrosER::createFromRequest($request);

        $conceptos = $this->domainService->obtenerConceptosER();
        $matriz = $this->domainService->obtenerDatosER($filtros);

        return [
            'conceptos' => $conceptos,
            'matriz' => $matriz,
        ];
    }
}