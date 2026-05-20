<?php

namespace Database\Seeders;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RegionalesSeeder::class,
            UnidadesOperativasSeeder::class,
            AlmacenSeeder::class,
            ConceptoERSeeder::class,
            CompromisosPoaSeeder::class,
            LineasProductosSeeder::class,
        ]);

        // Admin
        if (!User::where('email', 'admin@poa.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@poa.com',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
            ]);
        }

        // Supervisor
        if (!User::where('email', 'supervisor@poa.com')->exists()) {
            User::create([
                'name' => 'Supervisor',
                'email' => 'supervisor@poa.com',
                'password' => Hash::make('Super123!'),
                'role' => 'supervisor',
            ]);
        }

        // Capturistas (uno por almacén)
        $almacenes = Almacen::orderBy('id')->get();
        foreach ($almacenes as $almacen) {
            $email = 'capturista' . $almacen->id . '@poa.com';
            if (!User::where('email', $email)->exists()) {
                User::create([
                    'name' => 'Capturista ' . $almacen->nombre,
                    'email' => $email,
                    'password' => Hash::make('Captu' . $almacen->id . '!'),
                    'role' => 'capturista',
                    'almacen_id' => $almacen->id,
                ]);
            }
        }

        $this->command->info('Seeders ejecutados correctamente.');
    }
}
