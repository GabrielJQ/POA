<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\FiltrosPOA;
use App\Models\ConceptoMaestro;
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

        if ($filtros->isConsolidado()) {
            return $this->buildConsolidado($compromisos, $anio, $meses);
        }

        return $this->buildIndividual($compromisos, $anio, $almacenId, $meses);
    }

    public function sincronizarDesdeER(int $almacenId, int $anio): int
    {
        return 0;
    }

    private function buildIndividual($compromisos, int $anio, ?int $almacenId, array $meses): array
    {
        $dataPoa = [];

        foreach ($compromisos as $compromiso) {
            $conceptoNombre = trim($compromiso->concepto_er_nombre ?? '');

            $obj1 = new \stdClass();
            $obj1->meta_anual = 0;
            $obj1->nota_aclaratoria = '';

            $obj2 = new \stdClass();
            $obj2->meta_anual = 0;
            $obj2->nota_aclaratoria = '';

            // 1. Obtener COMPROMETIDO de registros_financieros
            $resultados = null;
            $conceptoER = null;
            
            if (!empty($conceptoNombre)) {
                $conceptoER = ConceptoMaestro::where('categoria', 'ER')
                    ->where('nombre', 'ilike', $conceptoNombre)
                    ->first();

                if (!$conceptoER) {
                    $conceptoER = ConceptoMaestro::where('categoria', 'ER')
                        ->where('nombre', 'ilike', '%' . $conceptoNombre . '%')
                        ->first();
                }

                if ($conceptoER) {
                    $query = RegistroFinanciero::where('concepto_id', $conceptoER->id)
                        ->where('anio', $anio)
                        ->where('tipo_dato', 'REAL');

                    if ($almacenId) {
                        $query->where('almacen_id', $almacenId);
                    }

                    $resultados = $query->get();

                    $metaAnual1 = 0;
                    foreach ($resultados as $r) {
                        $metaAnual1 += (float) $r->monto;
                    }
                    $obj1->meta_anual = $metaAnual1;
                }
            }

            foreach ($meses as $mes) {
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $obj1->$col = 0;
                if ($resultados) {
                    foreach ($resultados as $r) {
                        if ((int) $r->mes === $mes) {
                            $obj1->$col = (float) $r->monto;
                            break;
                        }
                    }
                }
            }

            // 2. Obtener REALIZADO (Ventas PAR/PE)
            $ventasParPeMes = [];
            if (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA') !== false) {
                $programaFilter = null;
                if (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA PAR') !== false) {
                    $programaFilter = 'PAR';
                } elseif (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA PE') !== false) {
                    $programaFilter = 'PE';
                } elseif (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA TOTAL') !== false) {
                    $programaFilter = null;
                }
                
                $ventasQuery = RegistroFinanciero::where('anio', $anio)
                    ->where('tipo_dato', 'REAL')
                    ->whereHas('concepto', function($q) {
                        $q->where('categoria', 'LINEA_PRODUCTO');
                    });
                
                if ($almacenId) {
                    $ventasQuery->where('almacen_id', $almacenId);
                }
                if ($programaFilter) {
                    $ventasQuery->where('programa', $programaFilter);
                }
                $ventas = $ventasQuery->get();
                
                $ventasParPeTotal = 0;
                foreach ($ventas as $v) {
                    $ventasParPeTotal += (float) $v->monto;
                    $mesKey = (int) $v->mes;
                    if (!isset($ventasParPeMes[$mesKey])) {
                        $ventasParPeMes[$mesKey] = 0;
                    }
                    $ventasParPeMes[$mesKey] += (float) $v->monto;
                }
                $obj2->meta_anual = $ventasParPeTotal;
            }
            
            foreach ($meses as $mes) {
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $obj2->$col = $ventasParPeMes[$mes] ?? 0;
            }

            $dataPoa[$compromiso->id][$compromiso->label_fila_1] = $obj1;
            $dataPoa[$compromiso->id][$compromiso->label_fila_2] = $obj2;
        }

        return $dataPoa;
    }

    private function buildConsolidado($compromisos, int $anio, array $meses): array
    {
        $dataPoa = [];

        foreach ($compromisos as $compromiso) {
            $conceptoNombre = trim($compromiso->concepto_er_nombre ?? '');

            $obj1 = new \stdClass();
            $obj1->meta_anual = 0;
            $obj1->nota_aclaratoria = '';

            $obj2 = new \stdClass();
            $obj2->meta_anual = 0;
            $obj2->nota_aclaratoria = '';

            // 1. Obtener COMPROMETIDO de registros_financieros
            $resultados = null;
            if (!empty($conceptoNombre)) {
                $conceptoER = ConceptoMaestro::where('categoria', 'ER')
                    ->where('nombre', 'ilike', $conceptoNombre)
                    ->first();

                if (!$conceptoER) {
                    $conceptoER = ConceptoMaestro::where('categoria', 'ER')
                        ->where('nombre', 'ilike', '%' . $conceptoNombre . '%')
                        ->first();
                }

                if ($conceptoER) {
                    $resultados = RegistroFinanciero::where('concepto_id', $conceptoER->id)
                        ->where('anio', $anio)
                        ->where('tipo_dato', 'REAL')
                        ->get();

                    $metaAnual1 = 0;
                    foreach ($resultados as $r) {
                        $metaAnual1 += (float) $r->monto;
                    }
                    $obj1->meta_anual = $metaAnual1;
                }
            }

            foreach ($meses as $mes) {
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $obj1->$col = 0;
                if ($resultados) {
                    foreach ($resultados as $r) {
                        if ((int) $r->mes === $mes) {
                            $obj1->$col = (float) $r->monto;
                            break;
                        }
                    }
                }
            }

            // 2. Obtener REALIZADO (Ventas PAR/PE)
            $ventasParPeMes = [];
            if (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA') !== false) {
                $programaFilter = null;
                if (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA PAR') !== false) {
                    $programaFilter = 'PAR';
                } elseif (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA PE') !== false) {
                    $programaFilter = 'PE';
                } elseif (stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA TOTAL') !== false) {
                    $programaFilter = null;
                }
                
                $ventasQuery = RegistroFinanciero::where('anio', $anio)
                    ->where('tipo_dato', 'REAL')
                    ->whereHas('concepto', function($q) {
                        $q->where('categoria', 'LINEA_PRODUCTO');
                    });
                
                if ($programaFilter) {
                    $ventasQuery->where('programa', $programaFilter);
                }
                $ventas = $ventasQuery->get();

                $ventasParPeTotal = 0;
                foreach ($ventas as $v) {
                    $ventasParPeTotal += (float) $v->monto;
                    $mesKey = (int) $v->mes;
                    if (!isset($ventasParPeMes[$mesKey])) {
                        $ventasParPeMes[$mesKey] = 0;
                    }
                    $ventasParPeMes[$mesKey] += (float) $v->monto;
                }
                $obj2->meta_anual = $ventasParPeTotal;
            }

            foreach ($meses as $mes) {
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $obj2->$col = $ventasParPeMes[$mes] ?? 0;
            }

            $label1 = $compromiso->label_fila_1 ?? 'COMPROMETIDO';
            $label2 = $compromiso->label_fila_2 ?? 'REALIZADO';

            $dataPoa[$compromiso->id][$label1] = $obj1;
            $dataPoa[$compromiso->id][$label2] = $obj2;
        }

        return $dataPoa;
    }
}
