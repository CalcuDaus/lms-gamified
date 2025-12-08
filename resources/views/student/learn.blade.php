@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1200px] flex-col mx-auto p-4">
        {{-- Header --}}
        <section
            class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6"
            style="--color-shadow:#9b9b9b;">
            <a href="{{ route('student.courses.learning-preview', $course->id) }}"
                class="px-5 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Overview
            </a>
            <div class="flex-1 text-center">
                <h1 class="text-3xl font-bold">{{ $course->title }}</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Interactive Learning</p>
            </div>
            <div class="px-5 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-xl font-bold">
                <i class="fa-solid fa-star mr-2"></i>{{ auth()->user()->xp }} XP
            </div>
        </section>

        {{-- Materials List --}}
        <section class="w-full">
            <div class="space-y-6">
                @php
                    $colorIndex = 0;
                    $colors = [
                        ['from' => 'from-red-500', 'to' => 'to-pink-500'],
                        ['from' => 'from-blue-500', 'to' => 'to-cyan-500'],
                        ['from' => 'from-green-500', 'to' => 'to-emerald-500'],
                        ['from' => 'from-purple-500', 'to' => 'to-pink-500'],
                        ['from' => 'from-orange-500', 'to' => 'to-yellow-500'],
                        ['from' => 'from-indigo-500', 'to' => 'to-purple-500'],
                    ];
                @endphp

                @foreach ($course->material as $index => $material)
                    @php
                        $gradient = $colors[$colorIndex % count($colors)];
                        $colorIndex++;
                    @endphp

                    <div class="shadow-custom rounded-3xl p-6 text-gray-600 dark:text-[#EEEEEE] hover:shadow-2xl transition-all"
                        style="--color-shadow:#9b9b9b;">
                        <div class="flex items-start gap-6">
                            {{-- Material Number Badge --}}
                            <div
                                class="flex-shrink-0 w-16 h-16 rounded-full bg-gradient-to-r {{ $gradient['from'] }} {{ $gradient['to'] }} flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                                {{ $index + 1 }}
                            </div>

                            {{-- Material Content --}}
                            <div class="flex-1">
                                <a href="{{ route('student.material.view', $material->id) }}" class="group block">
                                    <h3 class="text-2xl font-bold mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $material->title }}
                                        <i class="fa-solid fa-arrow-right ml-2 text-lg opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </h3>

                                    {{-- Material Description/Content --}}
                                    <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4 mb-4 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-all">
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {{ Str::limit($material->content ?? 'Learn about ' . $material->title, 150) }}
                                        </p>
                                        <span class="inline-block mt-2 text-blue-600 dark:text-blue-400 font-semibold text-sm group-hover:underline">
                                            Read more <i class="fa-solid fa-arrow-right ml-1"></i>
                                        </span>
                                    </div>
                                </a>

                                {{-- Material Stats --}}
                                <div class="flex items-center gap-6 mb-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-award text-yellow-500"></i>
                                        <span class="font-semibold">{{ $material->xp_reward }} XP</span>
                                    </div>
                                    @if ($material->quizzes->count() > 0)
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-clipboard-question text-blue-500"></i>
                                            <span class="font-semibold">{{ $material->quizzes->count() }}
                                                {{ $material->quizzes->count() === 1 ? 'Quiz' : 'Quizzes' }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Quizzes for this Material --}}
                                @if ($material->quizzes->count() > 0)
                                    <div class="space-y-3">
                                        @foreach ($material->quizzes as $quiz)
                                            @php
                                                $hasPassed = $userAttempts->contains(function ($attempt) use ($quiz) {
                                                    return $attempt->quiz_id === $quiz->id && $attempt->passed;
                                                });
                                            @endphp

                                            <div
                                                class="flex items-center justify-between p-4 bg-white dark:bg-gray-700 rounded-xl border-2 {{ $hasPassed ? 'border-green-500' : 'border-gray-300 dark:border-gray-600' }}">
                                                <div class="flex items-center gap-4">
                                                    @if ($hasPassed)
                                                        <i
                                                            class="fa-solid fa-circle-check text-2xl text-green-600"></i>
                                                    @else
                                                        <i class="fa-solid fa-circle text-2xl text-gray-400"></i>
                                                    @endif
                                                    <div>
                                                        <h4 class="font-bold text-lg">{{ $quiz->title }}</h4>
                                                        <div class="flex gap-4 text-sm text-gray-500 dark:text-gray-400">
                                                            <span><i class="fa-solid fa-clock mr-1"></i>{{ $quiz->time_limit }}
                                                                min</span>
                                                            <span><i
                                                                    class="fa-solid fa-check-double mr-1"></i>{{ $quiz->passing_score }}%
                                                                to pass</span>
                                                            <span><i
                                                                    class="fa-solid fa-star mr-1"></i>{{ $quiz->xp_reward }}
                                                                XP</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($hasPassed)
                                                    <div class="flex gap-2">
                                                        <span
                                                            class="px-4 py-2 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg font-bold">
                                                            <i class="fa-solid fa-trophy mr-2"></i>Completed
                                                        </span>
                                                        <a href="{{ route('student.quiz.start', $quiz->id) }}"
                                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                                                            <i class="fa-solid fa-rotate-right mr-2"></i>Retake
                                                        </a>
                                                    </div>
                                                @else
                                                    <a href="{{ route('student.quiz.start', $quiz->id) }}"
                                                        class="px-6 py-3 bg-gradient-to-r {{ $gradient['from'] }} {{ $gradient['to'] }} text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                                        <i class="fa-solid fa-play mr-2"></i>Start Quiz
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-4 bg-yellow-100 dark:bg-yellow-900 rounded-xl text-yellow-800 dark:text-yellow-200">
                                        <i class="fa-solid fa-info-circle mr-2"></i>No quizzes available for this material yet.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($course->material->count() === 0)
                    <div class="shadow-custom rounded-3xl p-12 text-center text-gray-600 dark:text-[#EEEEEE]"
                        style="--color-shadow:#9b9b9b;">
                        <i class="fa-solid fa-book-open text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">No Materials Yet</h3>
                        <p class="text-gray-500 dark:text-gray-400">The instructor hasn't added any materials to this course
                            yet.</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Course Completion Progress --}}
        @if ($course->material->count() > 0)
            <section class="w-full mt-8 shadow-custom rounded-3xl p-6 text-gray-600 dark:text-[#EEEEEE]"
                style="--color-shadow:#9b9b9b;">
                <h3 class="text-xl font-bold mb-4">Your Progress</h3>
                @php
                    $totalQuizzes = $course->material->sum(function ($material) {
                        return $material->quizzes->count();
                    });
                    $completedQuizzes = $userAttempts->filter(fn($attempt) => $attempt->passed)->count();
                    $progress = $totalQuizzes > 0 ? round(($completedQuizzes / $totalQuizzes) * 100) : 0;
                @endphp
                <div class="flex items-center gap-4">
                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-4 rounded-full transition-all duration-500"
                            style="width: {{ $progress }}%"></div>
                    </div>
                    <span class="font-bold text-lg">{{ $progress }}%</span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">{{ $completedQuizzes }} of {{ $totalQuizzes }}
                    quizzes completed</p>
            </section>
        @endif
    </div>
@endsection
