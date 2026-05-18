<?php

namespace App\Domain\Contracts\Repositories;

use Illuminate\Support\Collection;

interface IPoaNotaRepository
{
    public function getByAnioMesYAlmacen(int $anio, int $mes, ?int $almId = null): Collection;
    public function updateOrCreate(array $attrs, array $vals): void;
}
