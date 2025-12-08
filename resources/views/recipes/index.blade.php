<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Recipes
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto space-y-4">
        @if (session('status'))
            <div class="rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('recipes.create') }}"
               class="px-4 py-2 rounded-md bg-green-600 text-white text-sm font-semibold">
                Add Recipe
            </a>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-gray-500 uppercase text-xs tracking-widest">
                        <th class="py-2 px-4">Name</th>
                        <th class="py-2 px-4">Calories</th>
                        <th class="py-2 px-4">Protein (g)</th>
                        <th class="py-2 px-4">Carbs (g)</th>
                        <th class="py-2 px-4">Fat (g)</th>
                        <th class="py-2 px-4">Fiber (g)</th>
                        <th class="py-2 px-4">CO₂e (g)</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recipes as $recipe)
                        <tr class="border-b last:border-0">
                            <td class="py-2 px-4">{{ $recipe->title }}</td>
                            <td class="py-2 px-4">{{ $recipe->calories ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $recipe->protein_g ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $recipe->carbs_g ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $recipe->fat_g ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $recipe->fiber_g ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $recipe->carbon_grams ?? '-' }}</td>
                            <td class="py-2 px-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('recipes.edit', $recipe) }}"
                                       class="px-2 py-1 text-xs rounded bg-indigo-600 text-white">
                                        Edit
                                    </a>
                                    <form method="post"
                                          action="{{ route('recipes.destroy', $recipe) }}"
                                          onsubmit="return confirm('Delete this recipe?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-2 py-1 text-xs rounded bg-red-600 text-white">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-3 px-4 text-gray-500" colspan="8">
                                No recipes yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
