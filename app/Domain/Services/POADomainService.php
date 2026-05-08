<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\FiltrosPOA;
use App\Models\ConceptoMaestro;
use App\Models\PoaNota;
use App\Models\RegistroFinanciero;

class POADomainService
{
    public function obtenerDatosPOA(FiltrosPOA $filtros): array
    {
        $anio = $filtros->getAnio();
        $almacenId = $filtros->getAlmacenId();
        $meses = $filtros->getPeriodo()->getMeses();

        $compromisos = ConceptoMaestro::where('categoria', 'POA')
            ->orderBy('orden')
            ->get();

        $erConceptos = ConceptoMaestro::where('categoria', 'ER')->pluck('id', 'nombre');

        $metasPorConcepto = RegistroFinanciero::where('anio', $anio)
            ->where('tipo_dato', 'META')
            ->get()
            ->groupBy('concepto_id');

        $realesPorConcepto = RegistroFinanciero::where('anio', $anio)
            ->where('tipo_dato', 'REAL')
            ->get()
            ->groupBy('concepto_id');

        $ventasRecords = RegistroFinanciero::where('anio', $anio)
            ->where('tipo_dato', 'REAL')
            ->whereHas('concepto', fn($q) => $q->where('categoria', 'LINEA_PRODUCTO'))
            ->get();

        $notaMes = $filtros->getPeriodo()->getNotaMes();
        $notas = PoaNota::where('anio', $anio)
            ->where('mes', $notaMes)
            ->where(function ($q) use ($almacenId) {
                if ($almacenId === null) {
                    $q->whereNull('almacen_id');
                } else {
                    $q->where('almacen_id', $almacenId);
                }
            })
            ->get()
            ->keyBy(fn($n) => $n->concepto_id . '|' . $n->label);

        $dataPoa = $this->buildDataPoa(
            $compromisos, $erConceptos, $metasPorConcepto, $realesPorConcepto,
            $ventasRecords, $almacenId, $meses, $notas
        );

        return [
            'compromisos' => $compromisos,
            'dataPoa' => $dataPoa,
        ];
    }

    public function sincronizarDesdeER(int $almacenId, int $anio): int
    {
        return 0;
    }

    private function buildDataPoa(
        $compromisos, $erConceptos, $metasPorConcepto, $realesPorConcepto,
        $ventasRecords, ?int $almacenId, array $meses, $notas = null
    ): array {
        $dataPoa = [];
        $ventasPorPrograma = $ventasRecords->groupBy('programa');

        foreach ($compromisos as $compromiso) {
            $label1 = $compromiso->label_fila_1 ?? 'COMPROMETIDO';
            $label2 = $compromiso->label_fila_2 ?? 'REALIZADO';

            $obj1 = new \stdClass();
            $obj1->meta_anual = 0;
            $key1 = $compromiso->id . '|' . $label1;
            $nota1 = $notas ? ($notas->get($key1)?->nota_aclaratoria ?? '') : '';
            $obj1->nota_aclaratoria = $nota1;

            $obj2 = new \stdClass();
            $obj2->meta_anual = 0;
            $key2 = $compromiso->id . '|' . $label2;
            $nota2 = $notas ? ($notas->get($key2)?->nota_aclaratoria ?? '') : '';
            $obj2->nota_aclaratoria = $nota2;

            $ventasParPeMes = [];
            $esPorcentaje = stripos($compromiso->unidad_medida ?? '', 'PORCENTAJE') !== false;
            $metaConceptoId = $compromiso->id;

            $conceptoNombre = trim($compromiso->concepto_er_nombre ?? '');
            if ($conceptoNombre !== '') {
                $conceptoER = $erConceptos->get($conceptoNombre)
                    ?? $erConceptos->first(fn($id, $name) => stripos($name, $conceptoNombre) !== false
                        || stripos($conceptoNombre, $name) !== false);
                if ($conceptoER) {
                    $metaConceptoId = $conceptoER;
                }
            }

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
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
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
                    $col = 'mes_' . str_pad($m, 2, '0', STR_PAD_LEFT);
                    if ((float)($obj1->$col ?? 0) != 0) {
                        $anyMonthlyMeta = true;
                        break;
                    }
                }
                if (!$anyMonthlyMeta) {
                    $obj1->mes_01 = $obj1->meta_anual;
                }
            }

            $isVentas = stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA') !== false;
            if ($isVentas) {
                $programaFilter = null;
                if (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA PAR') !== false) {
                    $programaFilter = 'PAR';
                } elseif (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA PE') !== false) {
                    $programaFilter = 'PE';
                }

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
                    if (!isset($ventasParPeMes[$mesKey])) {
                        $ventasParPeMes[$mesKey] = 0;
                    }
                    $ventasParPeMes[$mesKey] += (float) $v->monto;
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
                    if (!isset($ventasParPeMes[$mesKey])) {
                        $ventasParPeMes[$mesKey] = 0;
                    }
                    $ventasParPeMes[$mesKey] += (float) $r->monto;
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
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $obj2->$col = $ventasParPeMes[$mes] ?? 0;
            }

            $dataPoa[$compromiso->id][$label1] = $obj1;
            $dataPoa[$compromiso->id][$label2] = $obj2;
        }

        return $dataPoa;
    }
}
