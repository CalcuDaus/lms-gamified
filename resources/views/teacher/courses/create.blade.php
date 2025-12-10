@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1200px] flex-col mx-auto p-4">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.'.strtolower(str_replace(' ', '_', $title))) }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ __('messages.create_course_description') }}</p>
            </div>
            <a href="{{ route('teacher.courses.index') }}" 
               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back
            </a>
        </div>

        {{-- Form --}}
        <div class="w-full shadow-custom rounded-3xl p-8">
            <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div class="mb-6">
                    <label for="title" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('messages.course_title') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           required
                           value="{{ old('title') }}"
                           class="w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                           style="--color-shadow:#9b9b9b;"
                           placeholder="{{ __('messages.enter_course_title') }}">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-6">
                    <label for="description" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('messages.course_description') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              required
                              rows="5"
                              class="w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                              style="--color-shadow:#9b9b9b;"
                              placeholder="Enter course description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Thumbnail --}}
                <div class="mb-6">
                    <label for="thumbnail" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Course Thumbnail
                    </label>
                    <input type="file" 
                           name="thumbnail" 
                           id="thumbnail"
                           accept="image/*"
                           class="w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                           style="--color-shadow:#9b9b9b;">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Recommended size: 600x400px</p>
                    @error('thumbnail')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    {{-- Preview --}}
                    <div id="thumbnailPreview" class="mt-4 hidden">
                        <img id="preview" src="" alt="Preview" class="rounded-xl max-w-md">
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex gap-4">
                    <button type="submit" 
                            class="px-8 py-4 bg-linear-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl transition-all">
                        <i class="fa-solid fa-check mr-2"></i>Create Course
                    </button>
                    <a href="{{ route('teacher.courses.index') }}" 
                       class="px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-bold text-lg hover:shadow-lg transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('thumbnailPreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
