<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RecipeController,
    MealController,
    GoalController,
    BiometricController,
    ProfileController,
    DashboardController
};

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Recipes: full CRUD except show
    Route::resource('recipes', RecipeController::class)->except(['show']);

    // Meals: now includes update
    Route::resource('meals', MealController::class)->only(['index', 'store', 'update', 'destroy']);

    // Goals
    Route::resource('goals', GoalController::class)->only(['index', 'store']);

    // Biometrics: now supports edit/update
    Route::resource('biometrics', BiometricController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy']);

    // Suggestions
    Route::get('/suggestions', [MealController::class, 'suggest'])->name('meals.suggest');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
