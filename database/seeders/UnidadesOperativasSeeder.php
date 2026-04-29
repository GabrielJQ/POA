<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regional;
use App\Models\UnidadOperativa;

class UnidadesOperativasSeeder extends Seeder
{
    public function run(): void
    {
        $oaxaca = Regional::where('nombre', 'Oaxaca')->first();

        if (!$oaxaca) {
            $oaxaca = Regional::create(['nombre' => 'Oaxaca']);
        }

        UnidadOperativa::updateOrCreate(
            ['nombre' => 'Valles Centrales'],
            ['regional_id' => $oaxaca->id, 'nombre' => 'Valles Centrales']
        );
    }
}
