<?php

namespace App\Domain\Contracts;

interface ICacheStore
{
    public function remember(string $key, int $ttl, callable $cb): mixed;
    public function get(string $key, mixed $default = null): mixed;
    public function put(string $key, mixed $val): void;
    public function increment(string $key): int;
}
