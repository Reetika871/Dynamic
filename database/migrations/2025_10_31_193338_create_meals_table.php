<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->date('served_on');
            $table->decimal('servings', 6, 2)->default(1);
            $table->timestamps();
            $table->index(['user_id','served_on']);
        });
    }
    public function down(): void { Schema::dropIfExists('meals'); }
};
