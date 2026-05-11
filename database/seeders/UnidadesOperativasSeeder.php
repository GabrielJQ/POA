<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regional;
use App\Models\UnidadOperativa;

class UnidadesOperativasSeeder extends Seeder
{
    public function run(): void
    {
        $oaxaca = Regional::where('nombre', 'OAXACA')->first();

        if (!$oaxaca) {
            $oaxaca = Regional::create(['nombre' => 'OAXACA']);
        }

        UnidadOperativa::updateOrCreate(
            ['nombre' => 'VALLES CENTRALES'],
            ['regional_id' => $oaxaca->id, 'nombre' => 'VALLES CENTRALES']
        );
    }
}
