<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\FiltrosER;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Domain\Contracts\ICacheStore;
use App\Domain\Shared\CacheKeys;

use App\Domain\Contracts\IERDomainService;

class ERDomainService implements IERDomainService
{
    public function __construct(
        private IConceptoMaestroRepository $conceptoRepo,
        private IRegistroFinancieroRepository $registroRepo,
        private ICacheStore $cache
    ) {}

    public function obtenerDatosER(FiltrosER $filtros): array
    {
        $anio = $filtros->getAnio();
        $almacenId = $filtros->getAlmacenId();

        $version = $this->cache->get(CacheKeys::POA_VERSION, 0);
        $cacheKey = CacheKeys::erData($anio, $almacenId, $version);

        return $this->cache->remember($cacheKey, 300, function () use ($anio, $almacenId) {
            $erConceptos = $this->conceptoRepo->getByCategoria('ER')->keyBy('id');

            $resultados = $this->registroRepo->getERMeta($anio, $erConceptos->keys()->toArray(), $almacenId);

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
        return $this->conceptoRepo->getByCategoria('ER')
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
        $upsertData = [];
        foreach ($datos as $dato) {
            $upsertData[] = [
                'almacen_id' => $dato['almacen_id'],
                'concepto_id' => $dato['concepto_id'],
                'anio' => $dato['anio'],
                'mes' => $dato['mes'],
                'tipo_dato' => 'REAL',
                'programa' => null,
                'monto' => $dato['monto']
            ];
        }

        if (!empty($upsertData)) {
            $this->registroRepo->upsertMany(
                $upsertData,
                ['almacen_id', 'concepto_id', 'anio', 'mes', 'tipo_dato', 'programa'],
                ['monto']
            );
        }
    }
}
