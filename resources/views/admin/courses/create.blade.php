@extends('layouts.app')

@section('content')
    <div class="max-w-[600px] mx-auto mt-10 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-custom font-balo">
        <h2 class="text-2xl font-semibold mb-6 text-center dark:text-gray-100">Create New Course</h2>

        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            {{-- Title --}}
            <div>
                <label for="title" class="block mb-1 font-medium dark:text-gray-200">Course Title</label>
                <input type="text" id="title" name="title"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block mb-1 font-medium dark:text-gray-200">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Thumbnail --}}
            <div>
                <label for="thumbnail" class="block mb-1 font-medium dark:text-gray-200">Thumbnail (optional)</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                    class="w-full text-gray-700 dark:text-gray-100">
                @error('thumbnail')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Submit --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('courses.index') }}"
                    class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                    Save Course
                </button>
            </div>
        </form>
    </div>
@endsection
