<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Recipe;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $date = $request->query('date', now()->toDateString());

        $meals = Meal::with('recipe')
            ->where('user_id', $user->id)
            ->whereDate('served_on', $date)
            ->orderBy('id')
            ->get();

        $totals = [
            'calories'      => 0,
            'protein_g'     => 0,
            'carbs_g'       => 0,
            'fat_g'         => 0,
            'fiber_g'       => 0,
            'carbon_grams'  => 0,
        ];

        foreach ($meals as $meal) {
            $r = $meal->recipe;
            $s = $meal->servings;

            $totals['calories']     += ($r->calories      ?? 0) * $s;
            $totals['protein_g']    += ($r->protein_g     ?? 0) * $s;
            $totals['carbs_g']      += ($r->carbs_g       ?? 0) * $s;
            $totals['fat_g']        += ($r->fat_g         ?? 0) * $s;
            $totals['fiber_g']      += ($r->fiber_g       ?? 0) * $s;
            $totals['carbon_grams'] += ($r->carbon_grams  ?? 0) * $s;
        }

        $recipes = Recipe::where('user_id', $user->id)
            ->orderBy('title')
            ->get();

        return view('meals.index', [
            'date'    => $date,
            'meals'   => $meals,
            'totals'  => $totals,
            'recipes' => $recipes,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'recipe_id' => ['required', 'exists:recipes,id'],
            'servings'  => ['required', 'numeric', 'min:0.1'],
            'served_on' => ['required', 'date'],
        ]);

        Meal::create([
            'user_id'   => $request->user()->id,
            'recipe_id' => $data['recipe_id'],
            'servings'  => $data['servings'],
            'served_on' => $data['served_on'],
        ]);

        return back(303)->with('status', 'Meal added.');
    }

    public function update(Request $request, Meal $meal)
    {
        if ($meal->user_id !== $request->user()->id) {
            abort(403, 'You can only edit your own meals.');
        }

        $data = $request->validate([
            'servings' => ['required', 'numeric', 'min:0.1'],
        ]);

        $meal->update([
            'servings' => $data['servings'],
        ]);

        return back(303)->with('status', 'Meal updated.');
    }

    public function destroy(Request $request, Meal $meal)
    {
        if ($meal->user_id !== $request->user()->id) {
            abort(403, 'You can only delete your own meals.');
        }

        $meal->delete();

        return back(303)->with('status', 'Meal deleted.');
    }

    public function suggest(Request $request)
    {
        $user = $request->user();
        $date = $request->query('date', now()->toDateString());

        $meals = Meal::with('recipe')
            ->where('user_id', $user->id)
            ->whereDate('served_on', $date)
            ->get();

        $totals = [
            'calories'      => 0,
            'protein_g'     => 0,
            'carbs_g'       => 0,
            'fat_g'         => 0,
            'fiber_g'       => 0,
            'carbon_grams'  => 0,
        ];

        foreach ($meals as $meal) {
            $r = $meal->recipe;
            $s = $meal->servings;

            $totals['calories']     += ($r->calories      ?? 0) * $s;
            $totals['protein_g']    += ($r->protein_g     ?? 0) * $s;
            $totals['carbs_g']      += ($r->carbs_g       ?? 0) * $s;
            $totals['fat_g']        += ($r->fat_g         ?? 0) * $s;
            $totals['fiber_g']      += ($r->fiber_g       ?? 0) * $s;
            $totals['carbon_grams'] += ($r->carbon_grams  ?? 0) * $s;
        }

        $goals = $user->goals()
            ->withPivot('direction', 'target_value')
            ->get()
            ->keyBy('key');

        $biggestKey     = null;
        $biggestGap     = 0;
        $goalDirection  = null;
        $goalTarget     = null;

        foreach ($goals as $key => $goal) {
            if (! array_key_exists($key, $totals)) {
                continue;
            }

            $current = $totals[$key] ?? 0;
            $target  = (float) $goal->pivot->target_value;
            $dir     = $goal->pivot->direction;

            if ($dir === 'increase') {
                $gap = max(0, $target - $current);
            } elseif ($dir === 'decrease') {
                $gap = max(0, $current - $target);
            } else {
                continue;
            }

            if ($gap > $biggestGap) {
                $biggestGap    = $gap;
                $biggestKey    = $key;
                $goalDirection = $dir;
                $goalTarget    = $target;
            }
        }

        $query = Recipe::where('user_id', $user->id);

        $recipeIdsToday = $meals->pluck('recipe_id')->unique()->all();
        if (! empty($recipeIdsToday)) {
            $query->whereNotIn('id', $recipeIdsToday);
        }

        if ($biggestKey && $biggestGap > 0) {
            $field = $biggestKey;

            if ($goalDirection === 'increase') {
                $query->where($field, '>', 0)
                      ->orderBy($field, 'desc');
            } else {
                $query->orderBy($field, 'asc');
            }
        } else {
            $query->orderBy('calories', 'asc');
        }

        $suggestions = $query
            ->take(5)
            ->get([
                'id',
                'title',
                'calories',
                'protein_g',
                'carbs_g',
                'fat_g',
                'fiber_g',
                'carbon_grams',
            ]);

        return response()->json($suggestions);
    }
}
