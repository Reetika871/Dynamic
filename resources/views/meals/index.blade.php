<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meals
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Date picker --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="get" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Date</label>
                        <input
                            type="date"
                            name="date"
                            value="{{ $date }}"
                            class="rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>
                    <button
                        class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold">
                        Go
                    </button>
                </form>
            </div>

            {{-- Add meal --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Add meal</h3>

                <form method="post" action="{{ route('meals.store') }}"
                      class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @csrf
                    <input type="hidden" name="served_on" value="{{ $date }}">

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Recipe</label>
                        <select name="recipe_id"
                                class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($recipes as $r)
                                <option value="{{ $r->id }}">{{ $r->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Servings</label>
                        <input
                            type="number"
                            name="servings"
                            step="0.1"
                            value="{{ old('servings', 1) }}"
                            class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    <div class="sm:self-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold">
                            Add
                        </button>
                    </div>
                </form>
            </div>

            {{-- Totals --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Today’s totals</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm">
                    <div>Calories: <strong>{{ (int) $totals['calories'] }}</strong></div>
                    <div>Protein (g): <strong>{{ number_format($totals['protein_g'], 2) }}</strong></div>
                    <div>Carbs (g): <strong>{{ number_format($totals['carbs_g'], 2) }}</strong></div>
                    <div>Fiber (g): <strong>{{ number_format($totals['fiber_g'], 2) }}</strong></div>
                    <div>Fat (g): <strong>{{ number_format($totals['fat_g'], 2) }}</strong></div>
                    <div>CO₂e (g): <strong>{{ (int) $totals['carbon_grams'] }}</strong></div>
                </div>
            </div>

            {{-- Meals list + suggestions --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">Meals for {{ $date }}</h3>
                    <button
                        id="suggest"
                        type="button"
                        class="px-3 py-2 bg-blue-600 text-white rounded-md text-sm font-semibold">
                        Suggest recipes
                    </button>
                </div>

                @if($meals->isEmpty())
                    <p class="text-gray-600 text-sm">No meals yet.</p>
                @else
                    <ul class="space-y-2 text-sm">
                        @foreach($meals as $m)
                            <li class="flex items-center justify-between gap-3">
                                <span>{{ $m->recipe->title }}</span>

                                <div class="flex items-center gap-2">
                                    <form method="post"
                                          action="{{ route('meals.update', $m) }}"
                                          class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input
                                            type="number"
                                            step="0.1"
                                            name="servings"
                                            value="{{ old('servings', $m->servings) }}"
                                            class="w-20 rounded-md border-gray-300 text-right text-xs focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                        <button type="submit"
                                                class="px-2 py-1 text-xs rounded bg-indigo-600 text-white">
                                            Save
                                        </button>
                                    </form>

                                    <form method="post"
                                          action="{{ route('meals.destroy', $m) }}"
                                          onsubmit="return confirm('Delete this meal?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-2 py-1 text-xs rounded bg-red-600 text-white">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <h4 class="font-semibold mt-6 mb-2">Suggestions</h4>
                <ul id="suggestions"
                    class="list-disc pl-5 space-y-1 text-sm text-gray-800">
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('suggest').addEventListener('click', async () => {
            const url = `{{ route('meals.suggest') }}?date={{ $date }}`;
            try {
                const res = await fetch(url);
                if (!res.ok) return;

                const data = await res.json();
                const ul = document.getElementById('suggestions');
                ul.innerHTML = '';

                if (!data.length) {
                    const li = document.createElement('li');
                    li.textContent = 'No suggestions available.';
                    ul.appendChild(li);
                    return;
                }

                data.forEach(r => {
                    const li = document.createElement('li');
                    li.textContent = `${r.title} — ${r.calories} kcal, CO₂e ${r.carbon_grams} g`;
                    ul.appendChild(li);
                });
            } catch (e) {
                console.error(e);
            }
        });
    </script>
</x-app-layout>
