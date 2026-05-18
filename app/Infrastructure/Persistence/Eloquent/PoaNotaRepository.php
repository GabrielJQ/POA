<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Contracts\Repositories\IPoaNotaRepository;
use App\Domain\Entities\PoaNota;
use Illuminate\Support\Collection;

class PoaNotaRepository implements IPoaNotaRepository
{
    public function getByAnioMesYAlmacen(int $anio, int $mes, ?int $almId = null): Collection
    {
        return PoaNota::where('anio', $anio)
            ->where('mes', $mes)
            ->where('almacen_id', $almId)
            ->get();
    }

    public function updateOrCreate(array $attrs, array $vals): void
    {
        PoaNota::updateOrCreate($attrs, $vals);
    }
}
