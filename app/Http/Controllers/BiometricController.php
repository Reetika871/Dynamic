<?php

namespace App\Http\Controllers;

use App\Models\Biometric;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BiometricController extends Controller
{
    public function index(): View
    {
        $rows = Biometric::where('user_id', auth()->id())
            ->orderByDesc('measured_on')
            ->orderByDesc('created_at')
            ->get();

        return view('biometrics.index', compact('rows'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['user_id'] = $request->user()->id;

        Biometric::create($data);

        return back()->with('status', 'Biometric entry added.');
    }

    public function edit(Biometric $biometric): View
    {
        if ($biometric->user_id !== auth()->id()) {
            abort(403);
        }

        return view('biometrics.edit', [
            'entry' => $biometric,
        ]);
    }

    public function update(Request $request, Biometric $biometric)
    {
        if ($biometric->user_id !== $request->user()->id) {
            abort(403);
        }

        $data = $this->validatedData($request);
        $biometric->fill($data)->save();

        return redirect()
            ->route('biometrics.index')
            ->with('status', 'Biometric entry updated.');
    }

    public function destroy(Biometric $biometric)
    {
        if ($biometric->user_id !== auth()->id()) {
            abort(403);
        }

        $biometric->delete();

        return back()->with('status', 'Biometric entry deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'measured_on' => ['required', 'date'],
            'weight_kg'   => ['nullable', 'numeric', 'min:0'],
            'systolic'    => ['nullable', 'integer', 'min:0'],
            'diastolic'   => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
