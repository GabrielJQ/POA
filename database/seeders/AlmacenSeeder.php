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
        $regional = Regional::firstOrCreate(
            ['nombre' => 'OAXACA'],
            ['nombre' => 'OAXACA']
        );

        $uo = UnidadOperativa::firstOrCreate(
            ['nombre' => 'VALLES CENTRALES'],
            ['regional_id' => $regional->id]
        );

        $almacenes = [
            ['nombre' => 'ALMACEN CENTRAL OAXACA', 'numero_almacen' => '1'],
            ['nombre' => 'AYUTLA MIXES', 'numero_almacen' => '2'],
            ['nombre' => 'CUAJIMOLOYAS', 'numero_almacen' => '3'],
            ['nombre' => 'SAN JOSE EL CHILAR', 'numero_almacen' => '4'],
            ['nombre' => 'IXTLAN DE JUAREZ', 'numero_almacen' => '5'],
            ['nombre' => 'SAN PEDRO JUCHATENGO', 'numero_almacen' => '6'],
            ['nombre' => 'LACHIXIO', 'numero_almacen' => '7'],
            ['nombre' => 'SANTIAGO MATATLAN', 'numero_almacen' => '8'],
            ['nombre' => 'MAGDALENA OCOTLAN', 'numero_almacen' => '9'],
            ['nombre' => 'SAN ANDRES HIDALGO', 'numero_almacen' => '10'],
            ['nombre' => 'SANTIAGO TEOTITLAN', 'numero_almacen' => '11'],
            ['nombre' => 'TAMAZULAPAN', 'numero_almacen' => '12'],
            ['nombre' => 'VALLES CENTRALES', 'numero_almacen' => '13'],
        ];

        foreach ($almacenes as $data) {
            Almacen::firstOrCreate(
                ['nombre' => $data['nombre']],
                [
                    'unidad_operativa_id' => $uo->id,
                    'numero_almacen' => $data['numero_almacen'],
                ]
            );
        }

        $this->command->info('Almacenes seedeados correctamente.');
    }
}
