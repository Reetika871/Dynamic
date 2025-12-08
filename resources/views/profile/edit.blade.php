<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Profile</h2>
    </x-slot>

    <div class="max-w-xl py-6">
        @if (session('status'))
            <div class="mb-4 text-green-700">{{ session('status') }}</div>
        @endif

        <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf @method('patch')
            <label class="block">
                <span class="block mb-1">Name</span>
                <input name="name" value="{{ old('name', $user->name) }}" class="border rounded w-full p-2">
                @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </label>

            <label class="block">
                <span class="block mb-1">Email</span>
                <input name="email" value="{{ old('email', $user->email) }}" class="border rounded w-full p-2">
                @error('email') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </label>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>

        <hr class="my-8">

        <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Delete your account?')">
            @csrf @method('delete')
            <label class="block">
                <span class="block mb-1">Confirm password</span>
                <input type="password" name="password" class="border rounded w-full p-2">
                @error('password') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </label>
            <button class="mt-3 bg-red-600 text-white px-4 py-2 rounded">Delete account</button>
        </form>
    </div>
</x-app-layout>
