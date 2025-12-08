<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Meal;
use App\Models\Biometric;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('dashboard', [
            'recipeCount' => Recipe::where('user_id', $user->id)->count(),
            'mealCount'   => Meal::where('user_id', $user->id)
                                 ->whereDate('served_on', now()->toDateString())
                                 ->count(),
            'bioCount'    => Biometric::where('user_id', $user->id)->count(),
        ]);
    }
}
