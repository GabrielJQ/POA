<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Entities\ConceptoMaestro;
use Illuminate\Support\Collection;
use App\Domain\Contracts\ICacheStore;
use App\Domain\Shared\CacheKeys;

class ConceptoMaestroRepository implements IConceptoMaestroRepository
{
    public function __construct(private ICacheStore $cache) {}

    public function getByCategoria(string $cat): Collection
    {
        $cacheKey = $cat === 'POA' ? CacheKeys::CONCEPTOS_POA : ($cat === 'ER' ? CacheKeys::CONCEPTOS_ER : "conceptos_cat_{$cat}");
        
        return $this->cache->remember($cacheKey, 86400, fn() =>
            ConceptoMaestro::where('categoria', $cat)->orderBy('orden')->get()
        );
    }

    public function pluckByCategoria(string $cat, string $key, string $val): Collection
    {
        $cacheKey = $cat === 'ER' ? CacheKeys::CONCEPTOS_ER_PLUCK : "conceptos_pluck_{$cat}_{$key}_{$val}";
        
        return $this->cache->remember($cacheKey, 86400, fn() =>
            ConceptoMaestro::where('categoria', $cat)->pluck($val, $key)
        );
    }

    public function pluckIdsByCategoria(string $cat): Collection
    {
        $cacheKey = $cat === 'LINEA_PRODUCTO' ? CacheKeys::CONCEPTOS_LP_IDS : "conceptos_ids_{$cat}";
        
        return $this->cache->remember($cacheKey, 86400, fn() =>
            ConceptoMaestro::where('categoria', $cat)->pluck('id')
        );
    }

    public function findByName(string $name, string $cat): ?ConceptoMaestro
    {
        return ConceptoMaestro::where('nombre', $name)->where('categoria', $cat)->first();
    }
}
