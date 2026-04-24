<?php

namespace App\Imports;

use App\Models\MovimientoCapital;
use App\Models\Tienda;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MovimientosImport implements ToModel, WithHeadingRow
{
    protected $tipo; // 'incremento' o 'decremento'

    public function __construct($tipo)
    {
        $this->tipo = $tipo;
    }

    public function model(array $row)
    {
        // Buscamos la tienda por su número (asumiendo que viene en el Excel)
        $tienda = Tienda::where('numero_tienda', $row['numero_tienda'])->first();

        if (!$tienda) {
            return null; // O podrías crear la tienda aquí mismo si no existe
        }

        return new MovimientoCapital([
            'folio' => $row['folio'],
            'tienda_id' => $tienda->id,
            'tipo' => $this->tipo,
            'fecha' => \Carbon\Carbon::parse($row['fecha']),
            'costo' => $row['costo'],
            'venta' => $row['venta'],
            'metadata' => json_encode($row), // Guardamos todo el resto de la fila por si acaso
        ]);
    }
}
