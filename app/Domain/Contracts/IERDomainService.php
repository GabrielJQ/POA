<?php

namespace App\Domain\Contracts;

use App\Domain\ValueObjects\FiltrosER;

interface IERDomainService
{
    public function obtenerDatosER(FiltrosER $filtros): array;
    public function obtenerConceptosER(): array;
    public function guardarManual(array $datos): void;
}
