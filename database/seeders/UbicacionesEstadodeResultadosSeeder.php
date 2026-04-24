<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regional;
use App\Models\UnidadOperativa;
use App\Models\Almacen;

class UbicacionesEstadodeResultadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Crear Región y obtener su ID
        $region = Regional::firstOrCreate(
            ['clave_region' => 'OAX'],
            ['nombre' => 'Oaxaca']
        );

        // 2. Crear Unidad Operativa usando el id_regional anterior
        $unidad = UnidadOperativa::firstOrCreate(
            ['clave_unidad' => 'VC'],
            [
                'nombre' => 'Valles Centrales',
                'regional_id' => $region->id
            ]
        );

        // 3. Crear Almacén usando el id de la unidad operativa recién generada
        $almacen = Almacen::firstOrCreate(
            ['clave_almacen' => 'AMX'],
            [
                'nombre' => 'Ayutla Mixes',
                'direccion' => 'Conocido Ayutla Mixes, Oaxaca',
                'unidad_operativa_id' => $unidad->id
            ]
        );
    }
}
