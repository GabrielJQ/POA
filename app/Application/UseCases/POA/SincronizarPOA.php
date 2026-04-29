<?php

namespace App\Application\UseCases\POA;

use App\Domain\Services\POADomainService;
use App\Models\Almacen;
use App\Models\ConceptoMaestro;

class SincronizarPOA
{
    private POADomainService $domainService;

    public function __construct(POADomainService $domainService)
    {
        $this->domainService = $domainService;
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

        $almacenes = Almacen::whereHas('registrosFinancieros', function ($q) use ($anio) {
            $q->where('anio', $anio)
              ->where('tipo_dato', 'REAL');
        })->pluck('id');

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
