<?php

namespace App\Application\UseCases\ER;

use App\Domain\ValueObjects\FiltrosER;
use App\Domain\Contracts\IERDomainService;
use App\Models\Almacen;
use Illuminate\Support\Facades\Cache;

class ObtenerDatosER
{
    private IERDomainService $domainService;

    public function __construct(IERDomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    public function execute(array $request): array
    {
        $filtros = FiltrosER::createFromRequest($request);

        $conceptos = $this->domainService->obtenerConceptosER();
        $matriz = $this->domainService->obtenerDatosER($filtros);
        $almacenes = Cache::remember('almacenes_ordenados', 86400, fn() =>
            Almacen::orderBy('nombre')->get()
        );

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