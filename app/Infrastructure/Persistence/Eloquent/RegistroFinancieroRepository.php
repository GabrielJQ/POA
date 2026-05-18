<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Domain\Entities\RegistroFinanciero;
use Illuminate\Support\Collection;

class RegistroFinancieroRepository implements IRegistroFinancieroRepository
{
    public function getByAnioYTipoDato(int $anio, array $tipos, ?int $almId = null): Collection
    {
        $query = RegistroFinanciero::where('anio', $anio)->whereIn('tipo_dato', $tipos);
        
        if ($almId) {
            $query->where('almacen_id', $almId);
        }
        
        return $query->get();
    }

    public function getERMeta(int $anio, array $concIds, ?int $almId = null): Collection
    {
        $query = RegistroFinanciero::whereIn('concepto_id', $concIds)
            ->where('anio', $anio)
            ->where('tipo_dato', 'META');
            
        if ($almId) {
            $query->where('almacen_id', $almId);
        }
        
        return $query->get();
    }

    public function upsertMany(array $rows, array $uniqueBy, array $update): void
    {
        RegistroFinanciero::upsert($rows, $uniqueBy, $update);
    }

    public function updateOrCreate(array $attrs, array $vals): void
    {
        RegistroFinanciero::updateOrCreate($attrs, $vals);
    }

    public function getDistinctAlmacenesByAnioYTipo(int $anio, string $tipo): Collection
    {
        return RegistroFinanciero::where('anio', $anio)
            ->where('tipo_dato', $tipo)
            ->select('almacen_id')
            ->distinct()
            ->get();
    }
}
