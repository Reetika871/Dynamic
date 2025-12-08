<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Biometrics
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


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">
                        Add biometric entry
                    </h3>

                    <form method="post" action="{{ route('biometrics.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @csrf

                        <div class="md:col-span-2">
                            <label class="block text-sm text-gray-700 mb-1">Date</label>
                            <input type="date" name="measured_on"
                                   value="{{ old('measured_on', now()->toDateString()) }}"
                                   class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight_kg"
                                   value="{{ old('weight_kg') }}"
                                   class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="e.g. 72.5">
                        </div>

                        <div class="md:col-span-2 flex gap-4">
                            <div class="flex-1">
                                <label class="block text-sm text-gray-700 mb-1">Sys</label>
                                <input type="number" name="systolic"
                                       value="{{ old('systolic') }}"
                                       class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="e.g. 120">
                            </div>

                            <div class="flex-1">
                                <label class="block text-sm text-gray-700 mb-1">Dia</label>
                                <input type="number" name="diastolic"
                                       value="{{ old('diastolic') }}"
                                       class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="e.g. 80">
                            </div>
                        </div>

                        <div class="md:col-span-4 flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                           rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                           hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                           focus:ring-indigo-500">
                                Save
                            </button>
                        </div>
                    </form>
                </div>


                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Latest values</h3>

                        @php $latest = $rows->first(); @endphp

                        @if ($latest)
                            <p class="text-sm text-gray-500 mb-4">
                                {{ $latest->measured_on->format('d.m.Y') }}
                            </p>

                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Weight</dt>
                                    <dd class="font-semibold">{{ $latest->weight_kg }} kg</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Blood pressure</dt>
                                    <dd class="font-semibold">
                                        {{ $latest->systolic }}/{{ $latest->diastolic }} mmHg
                                    </dd>
                                </div>
                            </dl>
                        @else
                            <p class="text-sm text-gray-600">
                                No entries yet. Add your first measurement on the left.
                            </p>
                        @endif
                    </div>
                </div>
            </div>



            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">History</h3>

                @if ($rows->isEmpty())
                    <p class="text-gray-600 text-sm">No entries yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b text-left text-gray-500 uppercase text-xs tracking-widest">
                                    <th class="py-2 pr-4">Date</th>
                                    <th class="py-2 pr-4">Weight (kg)</th>
                                    <th class="py-2 pr-4">Sys</th>
                                    <th class="py-2 pr-4">Dia</th>
                                    <th class="py-2 pr-4 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($rows as $row)
                                    <tr class="border-b last:border-0 hover:bg-gray-50">
                                        <td class="py-2 pr-4">
                                            {{ $row->measured_on->format('d.m.Y') }}
                                            @if ($loop->first)
                                                <span class="ml-2 text-xs px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700">
                                                    Latest
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-2 pr-4">{{ $row->weight_kg }}</td>
                                        <td class="py-2 pr-4">{{ $row->systolic }}</td>
                                        <td class="py-2 pr-4">{{ $row->diastolic }}</td>

                                        <td class="py-2 pr-4 text-right space-x-2">

                                            <a href="{{ route('biometrics.edit', $row) }}"
                                               class="px-3 py-1.5 text-xs font-semibold rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                                                Edit
                                            </a>

                                            <form method="post"
                                                  action="{{ route('biometrics.destroy', $row) }}"
                                                  onsubmit="return confirm('Delete this entry?');"
                                                  class="inline-block">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                        class="px-3 py-1.5 text-xs font-semibold rounded-md bg-red-600 text-white hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
