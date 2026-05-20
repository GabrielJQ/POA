<?php

namespace App\Domain\Services\Dashboard\Builders;

use App\Domain\Shared\ConceptMapper;
use App\Domain\Shared\PoaHelpers;

class EficienciaCalculator
{
    public function calcular(
        $almacenes, 
        $compromisos, 
        $erConceptos, 
        array $realesPoaGrouped, 
        array $metasGrouped, 
        array $ventasGrouped
    ): array {
        $indicePorAlmacen = [];

        foreach ($almacenes as $almacen) {
            $logros = [];
            $detalles = [];

            foreach ($compromisos as $compromiso) {
                $esPorcentaje = PoaHelpers::esPorcentaje($compromiso->unidad_medida);
                $metaConceptoId = ConceptMapper::mapPoaToErConceptId($compromiso, $erConceptos) ?? $compromiso->id;

                if ($esPorcentaje) {
                    $realSum = (float) ($realesPoaGrouped[$almacen->id][$metaConceptoId] ?? 0);

                    if ($realSum > 0) {
                        $pctLogro = max(0, min($realSum, 100));
                        $logros[] = $pctLogro;
                        $detalles[] = [
                            'concepto' => $compromiso->nombre,
                            'unidad_medida' => $compromiso->unidad_medida,
                            'meta' => 100,
                            'real' => $realSum,
                            'pct' => $pctLogro,
                        ];
                    }
                } else {
                    $metaSum = (float) ($metasGrouped[$almacen->id][$metaConceptoId] ?? 0);

                    if ($metaSum > 0) {
                        $isVentas = PoaHelpers::esVentas($compromiso->nombre);
                        if ($isVentas) {
                            $programa = PoaHelpers::detectarPrograma($compromiso->nombre);
                            if ($programa) {
                                $realSum = (float) ($ventasGrouped[$almacen->id][$programa] ?? 0);
                            } else {
                                $realSum = (float) ($ventasGrouped[$almacen->id]['TOTAL'] ?? 0);
                            }
                        } else {
                            $realSum = (float) ($realesPoaGrouped[$almacen->id][$metaConceptoId] ?? 0);
                        }

                        $pctLogro = $realSum > 0 ? min(($realSum / $metaSum) * 100, 100) : 0;
                        $logros[] = $pctLogro;
                        $detalles[] = [
                            'concepto' => $compromiso->nombre,
                            'unidad_medida' => $compromiso->unidad_medida,
                            'meta' => $metaSum,
                            'real' => $realSum,
                            'pct' => $pctLogro,
                        ];
                    }
                }
            }

            if (count($logros) > 0) {
                $indice = array_sum($logros) / count($logros);
            } else {
                $indice = null;
            }

            $indicePorAlmacen[] = [
                'id' => $almacen->id,
                'nombre' => $almacen->nombre,
                'indice' => $indice,
                'numConceptos' => count($logros),
                'detalles' => $detalles,
            ];
        }

        return $indicePorAlmacen;
    }
}
