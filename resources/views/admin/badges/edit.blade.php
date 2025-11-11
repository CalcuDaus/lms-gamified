@extends('layouts.app')

@section('content')
    <div class="max-w-[600px] mx-auto mt-10 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-custom font-balo">
        <h2 class="text-2xl font-semibold mb-6 text-center dark:text-gray-100">Edit Badge</h2>

        <form action="{{ route('badges.update', $badge->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block mb-1 font-medium dark:text-gray-200">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('name', $badge->name) }}" required>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block mb-1 font-medium dark:text-gray-200">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    dark:bg-gray-700 dark:text-gray-100">{{ old('description', $badge->description) }}</textarea>
            </div>

            {{-- Min XP --}}
            <div>
                <label for="min_xp" class="block mb-1 font-medium dark:text-gray-200">Minimum XP</label>
                <input type="number" id="min_xp" name="min_xp" min="0"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('min_xp', $badge->min_xp) }}">
            </div>

            {{-- Icon --}}
            <div>
                <label for="icon" class="block mb-1 font-medium dark:text-gray-200">Icon</label>
                @if ($badge->icon)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $badge->icon) }}" alt="{{ $badge->name }}"
                            class="w-16 h-16 object-cover rounded-md border dark:border-gray-600">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Current Icon</p>
                    </div>
                @endif

                <input type="file" id="icon" name="icon" accept="image/*"
                    class="w-full text-gray-700 dark:text-gray-100">
                <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">
                    Leave empty to keep the current icon.
                </p>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('badges.index') }}"
                    class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400 
                    dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                    Update Badge
                </button>
            </div>
        </form>
    </div>
@endsection
