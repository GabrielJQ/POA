<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regional;

class RegionalesSeeder extends Seeder
{
    public function run(): void
    {
        Regional::updateOrCreate(
            ['nombre' => 'Oaxaca'],
            ['nombre' => 'Oaxaca']
        );
    }
}
