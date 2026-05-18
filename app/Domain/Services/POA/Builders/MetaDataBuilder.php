<?php

namespace App\Domain\Services\POA\Builders;

use App\Domain\Shared\PoaHelpers;

class MetaDataBuilder
{
    public function build(
        bool $esPorcentaje,
        int $metaConceptoId,
        $metasPorConcepto,
        ?int $almacenId,
        array $meses
    ): \stdClass {
        $obj1 = new \stdClass();
        $obj1->meta_anual = 0;

        if ($esPorcentaje) {
            $obj1->meta_anual = 100;
            $resultados = collect();
            foreach ($meses as $mes) {
                $r = new \stdClass();
                $r->mes = $mes;
                $r->monto = 100;
                $resultados->push($r);
            }
        } else {
            $resultados = $metasPorConcepto->get($metaConceptoId, collect());
            if ($almacenId) {
                $resultados = $resultados->where('almacen_id', $almacenId);
            }
            $metaAnual = 0;
            foreach ($resultados as $r) {
                $metaAnual += (float) $r->monto;
            }
            $obj1->meta_anual = $metaAnual;
        }

        foreach ($meses as $mes) {
            $col = PoaHelpers::columnaMes($mes);
            $obj1->$col = 0;
            foreach ($resultados as $r) {
                if ((int) $r->mes === $mes) {
                    $obj1->$col += (float) $r->monto;
                }
            }
        }

        if (!$esPorcentaje && $obj1->meta_anual != 0) {
            $anyMonthlyMeta = false;
            for ($m = 1; $m <= 12; $m++) {
                $col = PoaHelpers::columnaMes($m);
                if ((float)($obj1->$col ?? 0) != 0) {
                    $anyMonthlyMeta = true;
                    break;
                }
            }
            if (!$anyMonthlyMeta) {
                $obj1->mes_01 = $obj1->meta_anual;
            }
        }

        return $obj1;
    }
}
