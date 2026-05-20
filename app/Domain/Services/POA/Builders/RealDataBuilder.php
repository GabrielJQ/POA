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
            $maxMes = max($meses);
            foreach ($ventas as $v) {
                $mesKey = (int) $v->mes;
                if ($mesKey === 0 || ($mesKey >= 1 && $mesKey <= $maxMes)) {
                    $totalReal += (float) $v->monto;
                }
                $ventasParPeMes[$mesKey] = ($ventasParPeMes[$mesKey] ?? 0) + (float) $v->monto;
            }

            $poaReales = $realesPorConcepto->get($metaConceptoId, collect());
            if ($almacenId) {
                $poaReales = $poaReales->where('almacen_id', $almacenId);
            }
            foreach ($poaReales as $pr) {
                $mesKey = (int) $pr->mes;
                if ($mesKey === 0 || ($mesKey >= 1 && $mesKey <= $maxMes)) {
                    $totalReal += (float) $pr->monto;
                }
                $ventasParPeMes[$mesKey] = ($ventasParPeMes[$mesKey] ?? 0) + (float) $pr->monto;
            }

            $obj2->meta_anual = $totalReal;
        } else {
            $reales = $realesPorConcepto->get($metaConceptoId, collect());
            if ($almacenId) {
                $reales = $reales->where('almacen_id', $almacenId);
            }

            $totalReal = 0;
            $maxMes = max($meses);
            foreach ($reales as $r) {
                $mesKey = (int) $r->mes;
                if ($mesKey === 0 || ($mesKey >= 1 && $mesKey <= $maxMes)) {
                    $totalReal += (float) $r->monto;
                }
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
