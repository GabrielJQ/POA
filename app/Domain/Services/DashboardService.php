<?php

namespace App\Domain\Services;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use Illuminate\Support\Facades\Cache;

use App\Domain\Contracts\IDashboardService;
use App\Domain\Shared\CacheKeys;
use App\Domain\Services\Dashboard\Builders\EficienciaCalculator;
use App\Domain\Services\Dashboard\Builders\DashboardDataAssembler;

class DashboardService implements IDashboardService
{
    public function __construct(
        private EficienciaCalculator $calculator,
        private DashboardDataAssembler $assembler
    ) {}

    public function calcularEficiencia(int $anio): array
    {
        $version = Cache::get(CacheKeys::POA_VERSION, 0);
        $cacheKey = CacheKeys::dashboardData($anio, $version);

        return Cache::remember($cacheKey, 300, function () use ($anio) {
            $almacenes = Cache::remember(CacheKeys::ALMACENES, 86400, fn() =>
                Almacen::orderBy('nombre')->get()
            );
            $compromisos = Cache::remember(CacheKeys::CONCEPTOS_POA, 86400, fn() =>
                ConceptoMaestro::where('categoria', 'POA')->orderBy('orden')->get()
            );
            $erConceptos = Cache::remember(CacheKeys::CONCEPTOS_ER_PLUCK, 86400, fn() =>
                ConceptoMaestro::where('categoria', 'ER')->pluck('id', 'nombre')
            );

            $records = RegistroFinanciero::where('anio', $anio)
                ->whereIn('tipo_dato', ['META', 'REAL'])
                ->get();

            $metas = $records->where('tipo_dato', 'META');
            $reales = $records->where('tipo_dato', 'REAL');

            $lpIds = Cache::remember(CacheKeys::CONCEPTOS_LP_IDS, 86400, fn() =>
                ConceptoMaestro::where('categoria', 'LINEA_PRODUCTO')->pluck('id')
            );

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
