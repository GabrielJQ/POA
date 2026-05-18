<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MovimientosImport implements ToCollection
{
    private string $tipo;

    public function __construct(string $tipo)
    {
        $this->tipo = $tipo;
    }

    public function collection(Collection $rows)
    {
        // TODO: Implementar lógica real de importación de movimientos
        // Se preservó para no tener referencias muertas
    }
}
