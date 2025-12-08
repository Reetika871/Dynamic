<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Recipe
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="post" action="{{ route('recipes.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf

                    <div class="sm:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1">Name</label>
                        <input name="title" required class="w-full rounded-md border-gray-300" />
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Calories</label>
                        <input name="calories" type="number" min="0" value="0" required class="w-full rounded-md border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Protein (g)</label>
                        <input name="protein_g" type="number" step="0.01" min="0" value="0" required class="w-full rounded-md border-gray-300" />
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Carbs (g)</label>
                        <input name="carbs_g" type="number" step="0.01" min="0" value="0" required class="w-full rounded-md border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Fat (g)</label>
                        <input name="fat_g" type="number" step="0.01" min="0" value="0" required class="w-full rounded-md border-gray-300" />
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Fiber (g)</label>
                        <input name="fiber_g" type="number" step="0.01" min="0" value="0" required class="w-full rounded-md border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">CO₂e (g)</label>
                        <input name="carbon_grams" type="number" min="0" value="0" required class="w-full rounded-md border-gray-300" />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1">Instructions</label>
                        <textarea name="instructions" class="w-full rounded-md border-gray-300" rows="4"></textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
