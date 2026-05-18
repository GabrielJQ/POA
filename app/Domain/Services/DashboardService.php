<?php

namespace App\Domain\Services;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function calcularEficiencia(int $anio): array
    {
        $version = Cache::get('poa_cache_version', 0);
        $cacheKey = 'dashboard_data_' . $anio . '_v' . $version;

        return Cache::remember($cacheKey, 300, function () use ($anio) {
            $almacenes = Cache::remember('almacenes_ordenados', 86400, fn() =>
                Almacen::orderBy('nombre')->get()
            );
            $compromisos = Cache::remember('conceptos_poa', 86400, fn() =>
                ConceptoMaestro::where('categoria', 'POA')->orderBy('orden')->get()
            );
            $erConceptos = Cache::remember('conceptos_er_pluck', 86400, fn() =>
                ConceptoMaestro::where('categoria', 'ER')->pluck('id', 'nombre')
            );

            $records = RegistroFinanciero::where('anio', $anio)
                ->whereIn('tipo_dato', ['META', 'REAL'])
                ->get();

            $metas = $records->where('tipo_dato', 'META');
            $reales = $records->where('tipo_dato', 'REAL');

            $lpIds = Cache::remember('conceptos_lp_ids', 86400, fn() =>
                ConceptoMaestro::where('categoria', 'LINEA_PRODUCTO')->pluck('id')
            );

            $ventas = $reales->filter(fn($r) => $lpIds->contains($r->concepto_id));
            $realesPOA = $reales->reject(fn($r) => $lpIds->contains($r->concepto_id));

            // Optimización de N+1 en memoria: pre-agrupar para evitar O(N*A*C) con collections
            $realesPoaGrouped = [];
            foreach ($realesPOA as $r) {
                $realesPoaGrouped[$r->almacen_id][$r->concepto_id] = ($realesPoaGrouped[$r->almacen_id][$r->concepto_id] ?? 0) + (float)$r->monto;
            }

            $metasGrouped = [];
            foreach ($metas as $m) {
                $metasGrouped[$m->almacen_id][$m->concepto_id] = ($metasGrouped[$m->almacen_id][$m->concepto_id] ?? 0) + (float)$m->monto;
            }

            $ventasGrouped = [];
            foreach ($ventas as $v) {
                $ventasGrouped[$v->almacen_id]['TOTAL'] = ($ventasGrouped[$v->almacen_id]['TOTAL'] ?? 0) + (float)$v->monto;
                if ($v->programa) {
                    $ventasGrouped[$v->almacen_id][$v->programa] = ($ventasGrouped[$v->almacen_id][$v->programa] ?? 0) + (float)$v->monto;
                }
            }

            $indicePorAlmacen = [];
        $totalSinDatos = 0;
        $enRojo = 0;
        $enAtencion = 0;

        foreach ($almacenes as $almacen) {
            $logros = [];
            $detalles = [];

            foreach ($compromisos as $compromiso) {
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
                    $realSum = (float) ($realesPoaGrouped[$almacen->id][$metaConceptoId] ?? 0);

                    if ($realSum > 0) {
                        $pctLogro = max(0, min($realSum, 100));
                        $logros[] = $pctLogro;
                        $detalles[] = [
                            'concepto' => $compromiso->nombre,
                            'meta' => 100,
                            'real' => $realSum,
                            'pct' => $pctLogro,
                        ];
                    }
                } else {
                    $metaSum = (float) ($metasGrouped[$almacen->id][$metaConceptoId] ?? 0);

                    if ($metaSum > 0) {
                        $isVentas = stripos($compromiso->nombre, 'PRESUPUESTO DE VENTA') !== false;
                        if ($isVentas) {
                            $programa = null;
                            if (stripos($compromiso->nombre, 'PAR') !== false) {
                                $programa = 'PAR';
                            } elseif (stripos($compromiso->nombre, 'PE') !== false) {
                                $programa = 'PE';
                            }
                            
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
                $totalSinDatos++;
            }

            if ($indice !== null) {
                if ($indice < 30) {
                    $enRojo++;
                } elseif ($indice < 50) {
                    $enAtencion++;
                }
            }

            $indicePorAlmacen[] = [
                'id' => $almacen->id,
                'nombre' => $almacen->nombre,
                'indice' => $indice,
                'numConceptos' => count($logros),
                'detalles' => $detalles,
            ];
        }

        usort($indicePorAlmacen, fn($a, $b) => ($a['indice'] ?? 999) <=> ($b['indice'] ?? 999));

        $conDatos = array_filter($indicePorAlmacen, fn($s) => $s['indice'] !== null);
        $conDatos = array_values($conDatos);

        $top3 = array_slice(array_reverse($conDatos), 0, 3);
        $bottom3 = array_slice($conDatos, 0, 3);

        $suma = 0;
        $count = 0;
        foreach ($indicePorAlmacen as $s) {
            if ($s['indice'] !== null) {
                $suma += $s['indice'];
                $count++;
            }
        }
        $indiceConsolidado = $count > 0 ? $suma / $count : 0;

            $totalAlmacenes = $almacenes->count();
            $totalConDatos = $totalAlmacenes - $totalSinDatos;

            return compact(
                'totalAlmacenes', 'totalConDatos', 'totalSinDatos',
                'indiceConsolidado', 'enRojo', 'enAtencion',
                'indicePorAlmacen', 'top3', 'bottom3',
            );
        });
    }
}
