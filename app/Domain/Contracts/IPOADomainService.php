<?php

namespace App\Domain\Contracts;

use App\Domain\ValueObjects\FiltrosPOA;

interface IPOADomainService
{
    public function obtenerDatosPOA(FiltrosPOA $filtros): array;
    public function sincronizarDesdeER(int $almacenId, int $anio): int;
}
