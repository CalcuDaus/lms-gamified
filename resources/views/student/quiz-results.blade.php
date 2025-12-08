@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[800px] flex-col mx-auto p-4">
        {{-- Results Header --}}
        <section
            class="flex flex-col gap-4 w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-8 mb-6 text-center relative overflow-hidden"
            style="--color-shadow:#9b9b9b;">
            @if ($attempt->passed)
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10"></div>
                <i class="fa-solid fa-circle-check text-8xl text-green-600 relative z-10"></i>
                <h1 class="text-4xl font-bold text-green-600 relative z-10">🎉 Congratulations!</h1>
                <p class="text-xl text-gray-700 dark:text-gray-300 relative z-10">You passed the quiz!</p>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-orange-500/10"></div>
                <i class="fa-solid fa-circle-xmark text-8xl text-red-600 relative z-10"></i>
                <h1 class="text-4xl font-bold text-red-600 relative z-10">Keep Trying!</h1>
                <p class="text-xl text-gray-700 dark:text-gray-300 relative z-10">Don't give up, you can do better!</p>
            @endif
        </section>

        {{-- Score Details --}}
        <section class="w-full shadow-custom rounded-3xl p-8 text-gray-600 dark:text-[#EEEEEE] mb-6"
            style="--color-shadow:#9b9b9b;">
            <h2 class="text-2xl font-bold mb-6 text-center">Your Results</h2>
            <div class="grid grid-cols-3 gap-6">
                <div class="text-center p-6 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800">
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Your Score</p>
                    <p class="text-4xl font-bold text-blue-600 dark:text-blue-300">{{ $attempt->score }}%</p>
                </div>
                <div class="text-center p-6 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900 dark:to-purple-800">
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Passing Score</p>
                    <p class="text-4xl font-bold text-purple-600 dark:text-purple-300">{{ $attempt->quiz->passing_score }}%</p>
                </div>
                <div class="text-center p-6 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900 dark:to-yellow-800">
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">XP Earned</p>
                    <p class="text-4xl font-bold text-yellow-600 dark:text-yellow-300">
                        @if ($attempt->passed)
                            <i class="fa-solid fa-star text-yellow-500"></i> {{ $attempt->xp_earned }}
                        @else
                            0
                        @endif
                    </p>
                </div>
            </div>
        </section>

        {{-- Quiz Information --}}
        <section class="w-full shadow-custom rounded-3xl p-8 text-gray-600 dark:text-[#EEEEEE] mb-6"
            style="--color-shadow:#9b9b9b;">
            <h3 class="text-xl font-bold mb-4">Quiz Information</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center pb-3 border-b border-gray-300 dark:border-gray-600">
                    <span class="text-gray-600 dark:text-gray-400">Quiz Title</span>
                    <span class="font-semibold">{{ $attempt->quiz->title }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-gray-300 dark:border-gray-600">
                    <span class="text-gray-600 dark:text-gray-400">Material</span>
                    <span class="font-semibold">{{ $attempt->quiz->material->title }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-gray-300 dark:border-gray-600">
                    <span class="text-gray-600 dark:text-gray-400">Completed At</span>
                    <span class="font-semibold">{{ $attempt->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Total Questions</span>
                    <span class="font-semibold">{{ $attempt->quiz->questions->count() }}</span>
                </div>
            </div>
        </section>

        {{-- Action Buttons --}}
        <div class="flex gap-4 w-full justify-center">
            <a href="{{ route('student.courses.learning-preview', $attempt->quiz->material->course_id) }}"
                class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Course
            </a>
            @if (!$attempt->passed)
                <a href="{{ route('student.quiz.start', $attempt->quiz->id) }}"
                    class="relative inline-flex items-center justify-center px-6 py-3 overflow-hidden tracking-tighter text-white bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl group shadow-lg hover:shadow-2xl transition-all">
                    <span class="relative font-bold">
                        <i class="fa-solid fa-rotate-right mr-2"></i> Retake Quiz
                    </span>
                </a>
            @else
                <a href="{{ route('student.dashboard') }}"
                    class="relative inline-flex items-center justify-center px-6 py-3 overflow-hidden tracking-tighter text-white bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl group shadow-lg hover:shadow-2xl transition-all">
                    <span class="relative font-bold">
                        <i class="fa-solid fa-home mr-2"></i> Continue Learning
                    </span>
                </a>
            @endif
        </div>
    </div>
@endsection
