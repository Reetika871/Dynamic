<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo-700 tracking-wide">
            🍽️ NutriTrack – Smart Meal & Health Planner
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 space-y-6">

            {{-- Top Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-xl shadow bg-indigo-100 border border-indigo-200">
                    <h3 class="text-lg font-semibold text-indigo-800">Total Recipes</h3>
                    <p class="text-3xl font-bold mt-2 text-indigo-900">{{ $recipeCount }}</p>
                </div>

                <div class="p-6 rounded-xl shadow bg-green-100 border border-green-200">
                    <h3 class="text-lg font-semibold text-green-800">Meals Logged Today</h3>
                    <p class="text-3xl font-bold mt-2 text-green-900">{{ $mealCount }}</p>
                </div>

                <div class="p-6 rounded-xl shadow bg-pink-100 border border-pink-200">
                    <h3 class="text-lg font-semibold text-pink-800">Biometric Records</h3>
                    <p class="text-3xl font-bold mt-2 text-pink-900">{{ $bioCount }}</p>
                </div>
            </div>

            {{-- Quick Navigation --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('recipes.index') }}"
                   class="block p-6 rounded-xl shadow hover:shadow-lg transition bg-white border">
                    <h3 class="text-xl font-semibold text-gray-800">📘 Recipes</h3>
                    <p class="text-sm mt-1 text-gray-600">View and manage your recipes.</p>
                </a>

                <a href="{{ route('meals.index') }}"
                   class="block p-6 rounded-xl shadow hover:shadow-lg transition bg-white border">
                    <h3 class="text-xl font-semibold text-gray-800">🍽 Meals</h3>
                    <p class="text-sm mt-1 text-gray-600">Track your meals and get suggestions.</p>
                </a>

                <a href="{{ route('biometrics.index') }}"
                   class="block p-6 rounded-xl shadow hover:shadow-lg transition bg-white border">
                    <h3 class="text-xl font-semibold text-gray-800">❤️ Biometrics</h3>
                    <p class="text-sm mt-1 text-gray-600">Track weight & blood pressure.</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
