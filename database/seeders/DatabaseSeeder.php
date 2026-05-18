<?php

namespace Database\Seeders;

use App\Domain\Entities\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!\App\Domain\Entities\User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            RegionalesSeeder::class,
            UnidadesOperativasSeeder::class,
            AlmacenSeeder::class,
            ConceptoERSeeder::class,
            CompromisosPoaSeeder::class,
            LineasProductosSeeder::class,
        ]);
    }
}
