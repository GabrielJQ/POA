<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\FiltrosER;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use Illuminate\Support\Facades\Cache;

class ERDomainService
{
    public function obtenerDatosER(FiltrosER $filtros): array
    {
        $anio = $filtros->getAnio();
        $almacenId = $filtros->getAlmacenId();

        $version = Cache::get('poa_cache_version', 0);
        $cacheKey = 'er_data_' . $anio . '_' . ($almacenId ?? 'all') . '_v' . $version;

        return Cache::remember($cacheKey, 300, function () use ($anio, $almacenId) {
            $erConceptos = Cache::remember('conceptos_er', 86400, fn() =>
                ConceptoMaestro::where('categoria', 'ER')->orderBy('orden')->get()
            )->keyBy('id');

            $query = RegistroFinanciero::whereIn('concepto_id', $erConceptos->keys())
                ->where('anio', $anio)
                ->where('tipo_dato', 'META');

            if ($almacenId) {
                $query->where('almacen_id', $almacenId);
            }

            $resultados = $query->get();

            $dataER = [];
            foreach ($resultados as $r) {
                $conceptoId = $r->concepto_id;
                if (!isset($dataER[$conceptoId])) {
                    $concept = $erConceptos->get($conceptoId);
                    $nombre = $concept ? $concept->nombre : 'Sin nombre';
                    $esTitulo = $concept && stripos($concept->nombre, 'GASTOS DE DISTRIBUCIÓN') !== false;

                    $dataER[$conceptoId] = (object)[
                        'id' => $conceptoId,
                        'nombre' => $nombre,
                        'montos' => array_fill(1, 12, 0),
                        'meta_anual' => 0,
                        'es_titulo' => $esTitulo,
                        'es_calculado' => false,
                    ];
                }

                $mes = (int)$r->mes;
                if ($mes >= 1 && $mes <= 12) {
                    $dataER[$conceptoId]->montos[$mes] = (float)$r->monto;
                    $dataER[$conceptoId]->meta_anual += (float)$r->monto;
                }
            }

            return $dataER;
        });
    }

    public function obtenerConceptosER(): array
    {
        return Cache::remember('conceptos_er', 86400, fn() =>
            ConceptoMaestro::where('categoria', 'ER')->orderBy('orden')->get()
        )
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'orden' => $item->orden,
                    'es_titulo' => stripos($item->nombre, 'GASTOS DE DISTRIBUCIÓN') !== false,
                    'es_calculado' => false,
                ];
            })
            ->toArray();
    }

    public function guardarManual(array $datos): void
    {
        foreach ($datos as $dato) {
            RegistroFinanciero::updateOrCreate(
                [
                    'almacen_id' => $dato['almacen_id'],
                    'concepto_id' => $dato['concepto_id'],
                    'anio' => $dato['anio'],
                    'mes' => $dato['mes'],
                    'tipo_dato' => 'REAL',
                    'programa' => null,
                ],
                ['monto' => $dato['monto']]
            );
        }
    }
}
