<?php

namespace Database\Seeders;

use App\Models\Almacen;
use App\Models\UnidadOperativa;
use App\Models\Regional;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Asegurar Regional
        $regional = Regional::firstOrCreate(
            ['nombre' => 'REGIONAL OAXACA'],
            ['nombre' => 'REGIONAL OAXACA']
        );

        // 2. Asegurar Unidad Operativa
        $uo = UnidadOperativa::firstOrCreate(
            ['nombre' => 'OAXACA VALLES CENTRALES'],
            ['regional_id' => $regional->id]
        );

        // 3. Almacenes Oficiales (Basados en el Reporte Consolidado)
        $almacenes = [
            'ALMACEN CENTRAL OAXACA',
            'AYUTLA MIXES',
            'CUAJIMOLOYAS',
            'SAN JOSE EL CHILAR',
            'IXTLAN DE JUAREZ',
            'SAN PEDRO JUCHATENGO',
            'LACHIXIO',
            'SANTIAGO MATATLAN',
            'MAGDALENA OCOTLAN',
            'SAN ANDRES HIDALGO',
            'SANTIAGO TEOTITLAN',
            'TAMAZULAPAN',
            'VALLES CENTRALES'
        ];

        foreach ($almacenes as $nombre) {
            // Usamos firstOrCreate para no duplicar si ya existen
            Almacen::firstOrCreate(
                ['nombre' => $nombre],
                ['unidad_operativa_id' => $uo->id]
            );
        }

        $this->command->info('Almacenes seedeados correctamente.');
    }
}
