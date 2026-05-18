<?php

namespace App\Domain\Contracts;

interface IDashboardService
{
    public function calcularEficiencia(int $anio): array;
}
