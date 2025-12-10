@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1200px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.add_quiz') }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $material->title }}</p>
            </div>
            <button onclick="history.back()" 
               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back
            </button>
        </div>

        {{-- Form --}}
        <div class="w-full shadow-custom rounded-3xl p-8">
            <form action="{{ route('teacher.quizzes.store', $material->id) }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="title" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('messages.quiz_title') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                           class="w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                           style="--color-shadow:#9b9b9b;"
                           placeholder="e.g., Laravel Basics Quiz">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="time_limit" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ __('messages.time_limit_minutes') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="time_limit" id="time_limit" required min="1" value="{{ old('time_limit', 15) }}"
                               class="w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                               style="--color-shadow:#9b9b9b;">
                        @error('time_limit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="passing_score" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Passing Score (%) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="passing_score" id="passing_score" required min="0" max="100" value="{{ old('passing_score', 70) }}"
                               class="w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                               style="--color-shadow:#9b9b9b;">
                        @error('passing_score')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="xp_reward" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            XP Reward <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="xp_reward" id="xp_reward" required min="0" value="{{ old('xp_reward', 100) }}"
                               class="w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                               style="--color-shadow:#9b9b9b;">
                        @error('xp_reward')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-4 mb-6">
                    <p class="text-blue-800 dark:text-blue-300">
                        <i class="fa-solid fa-info-circle mr-2"></i>
                        After creating the quiz, you'll be able to add questions to it.
                    </p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="px-8 py-4 bg-linear-to-r from-purple-600 to-pink-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl transition-all">
                        <i class="fa-solid fa-check mr-2"></i>Create Quiz
                    </button>
                    <button type="button" onclick="history.back()"
                       class="px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-bold text-lg hover:shadow-lg transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
