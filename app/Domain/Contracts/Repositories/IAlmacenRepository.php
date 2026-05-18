<?php

namespace App\Domain\Contracts\Repositories;

use Illuminate\Support\Collection;
use App\Domain\Entities\Almacen;

interface IAlmacenRepository
{
    public function findAllOrdered(): Collection;
    public function findById(int $id): ?Almacen;
    public function findByName(string $name): ?Almacen;
}
