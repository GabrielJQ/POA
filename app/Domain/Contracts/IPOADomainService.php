<?php

namespace App\Domain\Contracts;

use App\Domain\ValueObjects\FiltrosPOA;

interface IPOADomainService
{
    public function obtenerDatosPOA(FiltrosPOA $filtros): array;
}
