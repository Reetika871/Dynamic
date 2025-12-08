<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('goal_id')->constrained('goals')->cascadeOnDelete();
            $table->string('direction'); 
            $table->integer('target_value')->default(0);
            $table->timestamps();

            $table->unique(['user_id','goal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_goals');
    }
};
