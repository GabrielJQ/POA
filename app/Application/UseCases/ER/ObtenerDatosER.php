<?php

namespace App\Application\UseCases\ER;

use App\Domain\ValueObjects\FiltrosER;
use App\Domain\Services\ERDomainService;
use App\Models\Almacen;

class ObtenerDatosER
{
    private ERDomainService $domainService;

    public function __construct(ERDomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    public function execute(array $request): array
    {
        $filtros = FiltrosER::createFromRequest($request);

        $conceptos = $this->domainService->obtenerConceptos();
        $matriz = $this->domainService->obtenerDatosER($filtros);
        $almacenes = Almacen::all();

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

        $conceptos = $this->domainService->obtenerConceptos();
        $matriz = $this->domainService->obtenerDatosER($filtros);

        return [
            'conceptos' => $conceptos,
            'matriz' => $matriz,
        ];
    }
}