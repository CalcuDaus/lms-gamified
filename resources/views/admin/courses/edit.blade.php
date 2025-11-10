@extends('layouts.app')

@section('content')
    <div class="max-w-[600px] mx-auto mt-10 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-custom font-balo">
        <h2 class="text-2xl font-semibold mb-6 text-center dark:text-gray-100">Edit Course</h2>

        <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label for="title" class="block mb-1 font-medium dark:text-gray-200">Title</label>
                <input type="text" id="title" name="title"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('title', $course->title) }}" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block mb-1 font-medium dark:text-gray-200">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    dark:bg-gray-700 dark:text-gray-100">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Thumbnail --}}
            <div>
                <label for="thumbnail" class="block mb-1 font-medium dark:text-gray-200">Thumbnail</label>

                @if ($course->thumbnail)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Current Thumbnail"
                            class="w-24 h-24 object-cover rounded-md border dark:border-gray-600">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Current image</p>
                    </div>
                @endif

                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                    class="w-full text-gray-700 dark:text-gray-100">
                <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Leave empty to keep the current image.</p>
                @error('thumbnail')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('courses.index') }}"
                    class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400 
                    dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                    Update Course
                </button>
            </div>
        </form>
    </div>
@endsection
