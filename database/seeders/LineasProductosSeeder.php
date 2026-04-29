<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConceptoMaestro;

class LineasProductosSeeder extends Seeder
{
    public function run(): void
    {
        $lineas = [
            ['numero' => 1, 'nombre' => 'ABARROTES'],
            ['numero' => 15, 'nombre' => 'MAIZ'],
            ['numero' => 16, 'nombre' => 'FRIJOL'],
            ['numero' => 17, 'nombre' => 'ARROZ'],
            ['numero' => 18, 'nombre' => 'AZUCAR'],
            ['numero' => 23, 'nombre' => 'HARINA DE MAIZ'],
            ['numero' => 10, 'nombre' => 'MERCANCIAS GENERALES'],
            ['numero' => 7, 'nombre' => 'LECHE SUBSIDIADA'],
        ];

        foreach ($lineas as $linea) {
            ConceptoMaestro::updateOrCreate(
                ['numero' => $linea['numero'], 'categoria' => 'LINEA_PRODUCTO'],
                [
                    'categoria' => 'LINEA_PRODUCTO',
                    'nombre' => $linea['nombre'],
                    'numero' => $linea['numero'],
                ]
            );
        }
    }
}
