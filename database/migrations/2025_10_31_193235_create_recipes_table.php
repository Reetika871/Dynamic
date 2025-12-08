<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();

            // owner of the recipe
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // basic recipe info
            $table->string('title');
            $table->text('ingredients')->nullable();
            $table->text('instructions')->nullable();

            // nutritional & environmental details
            $table->unsignedInteger('calories')->default(0);
            $table->decimal('protein_g', 8, 2)->default(0);
            $table->decimal('carbs_g', 8, 2)->default(0);
            $table->decimal('fat_g', 8, 2)->default(0);
            $table->decimal('fiber_g', 8, 2)->default(0);
            $table->unsignedInteger('carbon_grams')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
