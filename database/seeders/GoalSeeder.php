<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoalSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // clear existing rows so we don't get duplicates on reseed
        DB::table('goals')->delete();

        DB::table('goals')->insert([
            [
                'key'        => 'calories',
                'label'      => 'Calories (kcal)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'carbs_g',
                'label'      => 'Carbohydrates (g)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'carbon_grams',
                'label'      => 'Carbon footprint (g CO₂e)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'fat_g',
                'label'      => 'Fat (g)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'fiber_g',
                'label'      => 'Fiber (g)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'protein_g',
                'label'      => 'Protein (g)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
