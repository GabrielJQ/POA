<?php

namespace App\Domain\Services;

use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Domain\Contracts\ICacheStore;

use App\Domain\Contracts\IDashboardService;
use App\Domain\Shared\CacheKeys;
use App\Domain\Services\Dashboard\Builders\EficienciaCalculator;
use App\Domain\Services\Dashboard\Builders\DashboardDataAssembler;

class DashboardService implements IDashboardService
{
    public function __construct(
        private EficienciaCalculator $calculator,
        private DashboardDataAssembler $assembler,
        private IAlmacenRepository $almacenRepo,
        private IConceptoMaestroRepository $conceptoRepo,
        private IRegistroFinancieroRepository $registroRepo,
        private ICacheStore $cache
    ) {}

    public function calcularEficiencia(int $anio): array
    {
        $version = $this->cache->get(CacheKeys::POA_VERSION, 0);
        $cacheKey = CacheKeys::dashboardData($anio, $version);

        return $this->cache->remember($cacheKey, 300, function () use ($anio) {
            $almacenes = $this->almacenRepo->findAllOrdered();
            $compromisos = $this->conceptoRepo->getByCategoria('POA');
            $erConceptos = $this->conceptoRepo->pluckByCategoria('ER', 'nombre', 'id');

            $records = $this->registroRepo->getByAnioYTipoDato($anio, ['META', 'REAL']);

            $metas = $records->where('tipo_dato', 'META');
            $reales = $records->where('tipo_dato', 'REAL');

            $lpIds = $this->conceptoRepo->pluckIdsByCategoria('LINEA_PRODUCTO');

            $ventas = $reales->filter(fn($r) => $lpIds->contains($r->concepto_id));
            $realesPOA = $reales->reject(fn($r) => $lpIds->contains($r->concepto_id));

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

            $indicePorAlmacen = $this->calculator->calcular(
                $almacenes, $compromisos, $erConceptos,
                $realesPoaGrouped, $metasGrouped, $ventasGrouped
            );

            return $this->assembler->assemble(
                $indicePorAlmacen,
                $almacenes->count()
            );
        });
    }
}
