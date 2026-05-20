<?php

namespace App\Domain\Contracts\Repositories;

use App\Domain\Entities\RegistroFinanciero;
use Illuminate\Support\Collection;

interface IRegistroFinancieroRepository
{
    public function getByAnioYTipoDato(int $anio, array $tipos, ?int $almId = null): Collection;
    public function getERMeta(int $anio, array $concIds, ?int $almId = null): Collection;
    public function upsertMany(array $rows, array $uniqueBy, array $update): void;
    public function updateOrCreate(array $attrs, array $vals): void;
    public function getDistinctAlmacenesByAnioYTipo(int $anio, string $tipo): Collection;
    public function findByUniqueKey(int $almacenId, int $conceptoId, int $mes, int $anio, string $tipoDato, ?string $programa): ?RegistroFinanciero;
    public function create(array $data): RegistroFinanciero;
}
