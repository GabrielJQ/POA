<?php

namespace App\Infrastructure\Cache;

use Illuminate\Support\Facades\Cache;
use App\Domain\Shared\CacheKeys;

class PoaCacheManager
{
    public static function invalidatePoaCache(): void
    {
        Cache::increment(CacheKeys::POA_VERSION);
    }
}
