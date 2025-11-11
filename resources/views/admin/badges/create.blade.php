@extends('layouts.app')

@section('content')
    <div class="max-w-[600px] mx-auto mt-10 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-custom font-balo">
        <h2 class="text-2xl font-semibold mb-6 text-center dark:text-gray-100">Create New Badge</h2>

        <form action="{{ route('badges.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block mb-1 font-medium dark:text-gray-200">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block mb-1 font-medium dark:text-gray-200">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    dark:bg-gray-700 dark:text-gray-100">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Min XP --}}
            <div>
                <label for="min_xp" class="block mb-1 font-medium dark:text-gray-200">Minimum XP</label>
                <input type="number" id="min_xp" name="min_xp" min="0"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('min_xp', 0) }}">
                @error('min_xp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Icon --}}
            <div>
                <label for="icon" class="block mb-1 font-medium dark:text-gray-200">Icon (optional)</label>
                <input type="file" id="icon" name="icon" accept="image/*"
                    class="w-full text-gray-700 dark:text-gray-100">
                @error('icon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('badges.index') }}"
                    class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400 
                    dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                    Save Badge
                </button>
            </div>
        </form>
    </div>
@endsection
