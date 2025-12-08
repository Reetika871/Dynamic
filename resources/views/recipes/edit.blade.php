<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit recipe
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form method="post" action="{{ route('recipes.update', $recipe) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Name</label>
                    <input type="text" name="title"
                           value="{{ old('title', $recipe->title) }}"
                           class="w-full rounded-md border-gray-300">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Calories</label>
                        <input type="number" name="calories"
                               value="{{ old('calories', $recipe->calories) }}"
                               class="w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Protein (g)</label>
                        <input type="number" step="0.1" name="protein_g"
                               value="{{ old('protein_g', $recipe->protein_g) }}"
                               class="w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Carbs (g)</label>
                        <input type="number" step="0.1" name="carbs_g"
                               value="{{ old('carbs_g', $recipe->carbs_g) }}"
                               class="w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Fat (g)</label>
                        <input type="number" step="0.1" name="fat_g"
                               value="{{ old('fat_g', $recipe->fat_g) }}"
                               class="w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Fiber (g)</label>
                        <input type="number" step="0.1" name="fiber_g"
                               value="{{ old('fiber_g', $recipe->fiber_g) }}"
                               class="w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">CO₂e (g)</label>
                        <input type="number" name="carbon_grams"
                               value="{{ old('carbon_grams', $recipe->carbon_grams) }}"
                               class="w-full rounded-md border-gray-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Instructions</label>
                    <textarea name="instructions" rows="4"
                              class="w-full rounded-md border-gray-300">{{ old('instructions', $recipe->instructions) }}</textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('recipes.index') }}"
                       class="px-4 py-2 rounded-md border text-sm">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm font-semibold">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
