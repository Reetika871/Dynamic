<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('recipes.index', compact('recipes'));
    }

    public function create(): View
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $data['user_id'] = $request->user()->id;

        Recipe::create($data);

        return redirect()
            ->route('recipes.index')
            ->with('status', 'Recipe added.');
    }

    public function edit(Recipe $recipe): View
    {
        if ($recipe->user_id !== auth()->id()) {
            abort(403);
        }

        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        if ($recipe->user_id !== $request->user()->id) {
            abort(403);
        }

        $data = $this->validatedData($request);

        $recipe->fill($data)->save();

        return redirect()
            ->route('recipes.index')
            ->with('status', 'Recipe updated.');
    }

    public function destroy(Recipe $recipe)
    {
        if ($recipe->user_id !== auth()->id()) {
            abort(403);
        }

        $recipe->delete();

        return redirect()
            ->route('recipes.index')
            ->with('status', 'Recipe deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'calories'      => ['nullable', 'numeric', 'min:0'],
            'protein_g'     => ['nullable', 'numeric', 'min:0'],
            'carbs_g'       => ['nullable', 'numeric', 'min:0'],
            'fat_g'         => ['nullable', 'numeric', 'min:0'],
            'fiber_g'       => ['nullable', 'numeric', 'min:0'],
            'carbon_grams'  => ['nullable', 'numeric', 'min:0'],
            'instructions'  => ['nullable', 'string'],
        ]);
    }
}
