<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Goals
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">

        @if (session('status'))
            <div class="rounded-md bg-green-50 border border-green-200 px-4 py-2 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @error('goal_id')
            <div class="rounded-md bg-red-50 border border-red-200 px-4 py-2 text-sm text-red-800">
                {{ $message }}
            </div>
        @enderror

        @error('target_value')
            <div class="rounded-md bg-red-50 border border-red-200 px-4 py-2 text-sm text-red-800">
                {{ $message }}
            </div>
        @enderror

        <div class="space-y-4">
            @foreach ($goals as $goal)
                @php
                    $active      = $user->goals->firstWhere('id', $goal->id);
                    $direction   = $active->pivot->direction ?? 'increase';
                    $targetValue = $active->pivot->target_value ?? '';
                @endphp

                <div class="bg-white border rounded-lg shadow-sm px-6 py-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="font-semibold text-gray-800">
                        {{ $goal->label }}
                    </div>

                    <form method="post" action="{{ route('goals.store') }}" class="flex flex-1 gap-3 md:justify-end">
                        @csrf
                        <input type="hidden" name="goal_id" value="{{ $goal->id }}">

                        <select name="direction" class="rounded-md border-gray-300 text-sm">
                            <option value="increase" {{ $direction === 'increase' ? 'selected' : '' }}>Increase</option>
                            <option value="decrease" {{ $direction === 'decrease' ? 'selected' : '' }}>Decrease</option>
                        </select>

                        <input
                            type="number"
                            name="target_value"
                            step="0.01"
                            placeholder="Target"
                            value="{{ $targetValue }}"
                            class="w-28 rounded-md border-gray-300 text-sm"
                        >

                        <button class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm">
                            Save
                        </button>
                    </form>

                    @if ($active)
                        <form method="post" action="{{ route('goals.store') }}">
                            @csrf
                            <input type="hidden" name="goal_id" value="{{ $goal->id }}">
                            <button class="px-4 py-2 rounded-md bg-red-600 text-white text-sm">
                                Remove
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="bg-white border rounded-lg shadow-sm px-6 py-4">
            <h3 class="font-semibold text-gray-800 mb-3">Your active goals</h3>

            @if ($user->goals->isEmpty())
                <p class="text-sm text-gray-500">You haven’t saved any goals yet.</p>
            @else
                <ul class="divide-y divide-gray-100 text-sm">
                    @foreach ($user->goals as $goal)
                        <li class="py-2 flex items-center justify-between">
                            <span>{{ $goal->label }}</span>
                            <span class="text-gray-700">
                                {{ ucfirst($goal->pivot->direction) }}
                                @if ($goal->pivot->target_value !== null)
                                    to <strong>{{ $goal->pivot->target_value }}</strong>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</x-app-layout>
