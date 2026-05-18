<?php

namespace App\Domain\Services\POA\Builders;

use App\Domain\Shared\PoaHelpers;

class RealDataBuilder
{
    public function build(
        string $nombreCompromiso,
        bool $esPorcentaje,
        int $metaConceptoId,
        $realesPorConcepto,
        $ventasRecords,
        $ventasPorPrograma,
        ?int $almacenId,
        array $meses
    ): \stdClass {
        $obj2 = new \stdClass();
        $obj2->meta_anual = 0;
        $ventasParPeMes = [];

        if (PoaHelpers::esVentas($nombreCompromiso)) {
            $programaFilter = PoaHelpers::detectarPrograma($nombreCompromiso);

            $ventas = $programaFilter !== null
                ? $ventasPorPrograma->get($programaFilter, collect())
                : $ventasRecords;
                
            if ($almacenId) {
                $ventas = $ventas->where('almacen_id', $almacenId);
            }

            $totalReal = 0;
            foreach ($ventas as $v) {
                $totalReal += (float) $v->monto;
                $mesKey = (int) $v->mes;
                $ventasParPeMes[$mesKey] = ($ventasParPeMes[$mesKey] ?? 0) + (float) $v->monto;
            }
            $obj2->meta_anual = $totalReal;
        } else {
            $reales = $realesPorConcepto->get($metaConceptoId, collect());
            if ($almacenId) {
                $reales = $reales->where('almacen_id', $almacenId);
            }

            $totalReal = 0;
            foreach ($reales as $r) {
                $totalReal += (float) $r->monto;
                $mesKey = (int) $r->mes;
                $ventasParPeMes[$mesKey] = ($ventasParPeMes[$mesKey] ?? 0) + (float) $r->monto;
            }

            if ($esPorcentaje && !$almacenId) {
                $storeCount = $reales->pluck('almacen_id')->unique()->count();
                if ($storeCount > 1) {
                    $totalReal /= $storeCount;
                    foreach ($ventasParPeMes as $m => $val) {
                        $ventasParPeMes[$m] = $val / $storeCount;
                    }
                }
            }

            $obj2->meta_anual = $totalReal;
        }

        foreach ($meses as $mes) {
            $col = PoaHelpers::columnaMes($mes);
            $obj2->$col = $ventasParPeMes[$mes] ?? 0;
        }

        return $obj2;
    }
}
