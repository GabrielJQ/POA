<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Entities\Almacen;
use Illuminate\Support\Collection;
use App\Domain\Contracts\ICacheStore;
use App\Domain\Shared\CacheKeys;

class AlmacenRepository implements IAlmacenRepository
{
    public function __construct(private ICacheStore $cache) {}

    public function findAllOrdered(): Collection
    {
        return $this->cache->remember(CacheKeys::ALMACENES, 86400, fn() =>
            Almacen::orderBy('nombre')->get()
        );
    }

    public function findById(int $id): ?Almacen
    {
        return Almacen::find($id);
    }

    public function findByName(string $name): ?Almacen
    {
        return Almacen::where('nombre', $name)->first();
    }
}
