<?php

namespace App\Application\UseCases\POA;

use App\Domain\Contracts\IPOADomainService;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;

class SincronizarPOA
{
    private IPOADomainService $domainService;
    private IRegistroFinancieroRepository $registroRepo;

    public function __construct(IPOADomainService $domainService, IRegistroFinancieroRepository $registroRepo)
    {
        $this->domainService = $domainService;
        $this->registroRepo = $registroRepo;
    }

    public function execute(int $anio, ?int $almacenId = null): array
    {
        if ($almacenId) {
            $count = $this->domainService->sincronizarDesdeER($almacenId, $anio);
            return [
                'message' => "Metas POA sincronizadas ({$count} compromisos actualizados).",
                'count' => $count,
            ];
        }

        $almacenes = $this->registroRepo->getDistinctAlmacenesByAnioYTipo($anio, 'REAL')
            ->pluck('almacen_id');

        $totalCount = 0;
        foreach ($almacenes as $id) {
            $totalCount += $this->domainService->sincronizarDesdeER($id, $anio);
        }

        return [
            'message' => "Metas POA sincronizadas para {$almacenes->count()} almacén(es), {$totalCount} compromisos actualizados.",
            'count' => $totalCount,
            'almacenesCount' => $almacenes->count(),
        ];
    }
}
