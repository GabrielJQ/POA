<?php

namespace App\Infrastructure\Cache;

use App\Domain\Contracts\ICacheStore;
use Illuminate\Support\Facades\Cache;

class LaravelCacheStore implements ICacheStore
{
    public function remember(string $key, int $ttl, callable $cb): mixed
    {
        return Cache::remember($key, $ttl, $cb);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    public function put(string $key, mixed $val): void
    {
        Cache::put($key, $val);
    }

    public function increment(string $key): int
    {
        return Cache::increment($key);
    }
}
