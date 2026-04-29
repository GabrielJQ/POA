<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadOperativa;
use App\Models\Almacen;

class AlmacenesSeeder extends Seeder
{
    public function run(): void
    {
        $vallesCentrales = UnidadOperativa::where('nombre', 'Valles Centrales')->first();

        if (!$vallesCentrales) {
            $oaxaca = \App\Models\Regional::where('nombre', 'Oaxaca')->first();
            if (!$oaxaca) {
                $oaxaca = \App\Models\Regional::create(['nombre' => 'Oaxaca']);
            }
            $vallesCentrales = UnidadOperativa::create([
                'regional_id' => $oaxaca->id,
                'nombre' => 'Valles Centrales'
            ]);
        }

        Almacen::updateOrCreate(
            ['nombre' => 'Ayutla Mixes'],
            [
                'unidad_operativa_id' => $vallesCentrales->id,
                'nombre' => 'Ayutla Mixes'
            ]
        );
    }
}
