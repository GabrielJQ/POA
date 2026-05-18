<?php

namespace App\Domain\Shared;

use Illuminate\Support\Facades\Cache;

class CacheManager
{
    /**
     * Invalida el caché subiendo la versión de los datos del POA
     * Se debe llamar siempre que cambien los registros financieros
     */
    public static function invalidatePoaCache(): void
    {
        $currentVersion = Cache::get(CacheKeys::POA_VERSION, 0);
        Cache::put(CacheKeys::POA_VERSION, $currentVersion + 1);
    }
}
