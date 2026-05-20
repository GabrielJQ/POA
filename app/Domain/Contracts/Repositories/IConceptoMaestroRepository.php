<?php

namespace App\Domain\Contracts\Repositories;

use Illuminate\Support\Collection;
use App\Domain\Entities\ConceptoMaestro;

interface IConceptoMaestroRepository
{
    public function getByCategoria(string $cat): Collection;
    public function pluckByCategoria(string $cat, string $key, string $val): Collection;
    public function pluckIdsByCategoria(string $cat): Collection;
    public function findByName(string $name, string $cat): ?ConceptoMaestro;
    public function findById(int $id): ?ConceptoMaestro;
}
