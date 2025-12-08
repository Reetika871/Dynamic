<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: rename the old table temporarily
        Schema::rename('user_goals', 'user_goals_old');

        // Step 2: create a new table with correct column definition
        Schema::create('user_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('goal_id')->constrained()->cascadeOnDelete();

            // NEW SAFE COLUMN: no check constraint, no errors
            $table->string('direction')->default('increase');

            $table->integer('target_value')->default(0);
            $table->timestamps();
        });

        // Step 3: copy the existing data safely
        DB::table('user_goals_old')->orderBy('id')->chunk(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('user_goals')->insert([
                    'id'           => $row->id,
                    'user_id'      => $row->user_id,
                    'goal_id'      => $row->goal_id,
                    'direction'    => $row->direction ?? 'increase',
                    'target_value' => $row->target_value ?? 0,
                    'created_at'   => $row->created_at,
                    'updated_at'   => $row->updated_at,
                ]);
            }
        });

        // Step 4: drop old table
        Schema::dropIfExists('user_goals_old');
    }

    public function down(): void
    {
        // no rollback needed for the project
    }
};
