<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $user  = auth()->user()->load('goals');
        $goals = Goal::orderBy('label')->get();

        return view('goals.index', compact('goals', 'user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'goal_id'      => ['required','exists:goals,id'],
            'direction'    => ['nullable','string'],
            'target_value' => ['nullable','numeric'],
        ]);

        $user   = $request->user();
        $goalId = (int) $data['goal_id'];

        if ($user->goals()->where('goal_id', $goalId)->exists()) {
            $user->goals()->detach($goalId);
            return back()->with('status', 'Goal removed.');
        }

        $direction = $data['direction'] ?? 'increase';
        $target    = $data['target_value'] ?? 0;

        $user->goals()->attach($goalId, [
            'direction'    => $direction,
            'target_value' => $target,
        ]);

        return back()->with('status', 'Goal saved.');
    }
}
