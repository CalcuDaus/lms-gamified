@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] flex-col mx-auto p-4">
        {{-- Header --}}
        <section
            class="flex flex-wrap gap-4 justify-center md:justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-4 md:p-6 mb-6"
            style="--color-shadow:#9b9b9b;">
            <a href="{{ route('student.courses.learning-preview', $course->id) }}"
                class="px-4 md:px-5 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all text-sm md:text-base order-1">
                <i class="fa-solid fa-arrow-left mr-1 md:mr-2"></i> <span class="hidden sm:inline">{{ __('messages.back_to_overview') }}</span><span class="sm:hidden">Back</span>
            </a>
            <div class="flex-1 text-center order-3 md:order-2 w-full md:w-auto mt-2 md:mt-0">
                <h1 class="text-xl md:text-3xl font-bold">{{ $course->title }}</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm md:text-base">{{ __('messages.interactive_learning') }}</p>
            </div>
            <div
                class="px-4 md:px-5 py-2 bg-linear-to-r from-yellow-400 to-orange-500 text-white rounded-xl font-bold text-sm md:text-base order-2 md:order-3">
                <i class="fa-solid fa-star mr-1 md:mr-2"></i>{{ auth()->user()->xp }} XP
            </div>
            </section>

            {{-- Materials List --}}
            <section class="w-full">
                <div class="space-y-4 md:space-y-6">
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

                    @foreach ($materials as $index => $material)
                        @php
                            $gradient = $colors[$colorIndex % count($colors)];
                            $colorIndex++;
                            // Calculate the actual material number across pages
                            $materialNumber = ($materials->currentPage() - 1) * $materials->perPage() + $index + 1;
                        @endphp

                        <div class="shadow-custom rounded-3xl p-4 md:p-6 text-gray-600 dark:text-[#EEEEEE] hover:shadow-2xl transition-all"
                            style="--color-shadow:#9b9b9b;">
                            <div class="flex flex-col sm:flex-row items-start gap-4 md:gap-6">
                                {{-- Material Number Badge --}}
                                <div
                                    class="shrink-0 w-12 h-12 md:w-16 md:h-16 rounded-full bg-linear-to-r {{ $gradient['from'] }} {{ $gradient['to'] }} flex items-center justify-center text-white font-bold text-xl md:text-2xl shadow-lg">
                                    {{ $materialNumber }}
                                </div>

                                {{-- Material Content --}}
                                <div class="flex-1 w-full">
                                    <a href="{{ route('student.material.view', $material->id) }}" class="group block">
                                        <h3
                                            class="text-xl md:text-2xl font-bold mb-2 md:mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ $material->title }}
                                            <i
                                                class="fa-solid fa-arrow-right ml-2 text-sm md:text-lg opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                        </h3>

                                        {{-- Material Description/Content --}}
                                        <div
                                            class="bg-gray-100 dark:bg-gray-800 rounded-xl p-3 md:p-4 mb-3 md:mb-4 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-all">
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm md:text-base">
                                                {{ Str::limit($material->content ?? __('messages.learn_about') . ' ' . $material->title, 150) }}
                                            </p>
                                            <span
                                                class="inline-block mt-2 text-blue-600 dark:text-blue-400 font-semibold text-xs md:text-sm group-hover:underline">
                                                {{ __('messages.read_more') }} <i class="fa-solid fa-arrow-right ml-1"></i>
                                            </span>
                                        </div>
                                    </a>

                                    {{-- Material Stats --}}
                                    <div class="flex flex-wrap items-center gap-3 md:gap-6 mb-3 md:mb-4">
                                        <div class="flex items-center gap-2 text-sm md:text-base">
                                            <i class="fa-solid fa-award text-yellow-500"></i>
                                            <span class="font-semibold">{{ $material->xp_reward }} XP</span>
                                        </div>
                                        @if ($material->quizzes->count() > 0)
                                            <div class="flex items-center gap-2 text-sm md:text-base">
                                                <i class="fa-solid fa-clipboard-question text-blue-500"></i>
                                                <span class="font-semibold">{{ $material->quizzes->count() }}
                                                    {{ $material->quizzes->count() === 1 ? __('messages.quiz') : __('messages.quizzes') }}</span>
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
                                                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3 md:p-4 bg-white dark:bg-gray-700 rounded-xl border-2 {{ $hasPassed ? 'border-green-500' : 'border-gray-300 dark:border-gray-600' }}">
                                                    <div class="flex items-center gap-3 md:gap-4">
                                                        @if ($hasPassed)
                                                            <i class="fa-solid fa-circle-check text-xl md:text-2xl text-green-600"></i>
                                                        @else
                                                            <i class="fa-solid fa-circle text-xl md:text-2xl text-gray-400"></i>
                                                        @endif
                                                        <div>
                                                            <h4 class="font-bold text-base md:text-lg">{{ $quiz->title }}</h4>
                                                            <div
                                                                class="flex flex-wrap gap-2 md:gap-4 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                                <span><i class="fa-solid fa-clock mr-1"></i>{{ $quiz->time_limit }}
                                                                    {{ __('messages.min') }}</span>
                                                                <span><i class="fa-solid fa-check-double mr-1"></i>{{ $quiz->passing_score }}%
                                                                    {{ __('messages.to_pass') }}</span>
                                                                <span><i class="fa-solid fa-star mr-1"></i>{{ $quiz->xp_reward }}
                                                                    XP</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($hasPassed)
                                                        <div class="flex flex-wrap gap-2">
                                                            <span
                                                                class="px-3 md:px-4 py-2 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg font-bold text-xs md:text-sm">
                                                                <i class="fa-solid fa-trophy mr-1 md:mr-2"></i>{{ __('messages.completed') }}
                                                            </span>
                                                            <a href="{{ route('student.quiz.start', $quiz->id) }}"
                                                                class="px-3 md:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-xs md:text-sm">
                                                                <i class="fa-solid fa-rotate-right mr-1 md:mr-2"></i>{{ __('messages.retake') }}
                                                            </a>
                                                        </div>
                                                    @else
                                                        <a href="{{ route('student.quiz.start', $quiz->id) }}"
                                                            class="px-4 md:px-6 py-2 md:py-3 bg-linear-to-r {{ $gradient['from'] }} {{ $gradient['to'] }} text-white rounded-xl font-bold hover:shadow-lg transition-all text-sm md:text-base text-center">
                                                            <i class="fa-solid fa-play mr-1 md:mr-2"></i>{{ __('messages.start_quiz') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div
                                            class="p-3 md:p-4 bg-yellow-100 dark:bg-yellow-900 rounded-xl text-yellow-800 dark:text-yellow-200 text-sm md:text-base">
                                            <i class="fa-solid fa-info-circle mr-2"></i>{{ __('messages.no_quizzes_available') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($materials->count() === 0)
                        <div class="shadow-custom rounded-3xl p-8 md:p-12 text-center text-gray-600 dark:text-[#EEEEEE]"
                            style="--color-shadow:#9b9b9b;">
                            <i class="fa-solid fa-book-open text-4xl md:text-6xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl md:text-2xl font-bold mb-2">{{ __('messages.no_materials_yet') }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base">{{ __('messages.no_materials_added_yet') }}
                            </p>
                        </div>
                    @endif

                    {{-- Pagination Links --}}
                    @if ($materials->hasPages())
                        <div class="mt-6">
                            {{ $materials->links() }}
                        </div>
                    @endif
                </div>
            </section>

            {{-- Course Completion Progress --}}
            @if ($materials->count() > 0)
                <section class="w-full mt-6 md:mt-8 shadow-custom rounded-3xl p-4 md:p-6 text-gray-600 dark:text-[#EEEEEE]"
                    style="--color-shadow:#9b9b9b;">
                    <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4">{{ __('messages.your_progress') }}</h3>
                    @php
                        $totalQuizzes = $course->material->sum(function ($material) {
                            return $material->quizzes->count();
                        });
                        $completedQuizzes = $userAttempts->filter(fn($attempt) => $attempt->passed)->count();
                        $progress = $totalQuizzes > 0 ? round(($completedQuizzes / $totalQuizzes) * 100) : 0;
                    @endphp
                    <div class="flex items-center gap-3 md:gap-4">
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-3 md:h-4">
                            <div class="bg-linear-to-r from-green-500 to-emerald-600 h-3 md:h-4 rounded-full transition-all duration-500"
                                style="width: {{ $progress }}%"></div>
                        </div>
                        <span class="font-bold text-base md:text-lg">{{ $progress }}%</span>
                    </div>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-xs md:text-sm">{{ $completedQuizzes }} {{ __('messages.of') }}
                            {{ $totalQuizzes }}
                            {{ __('messages.quizzes_completed') }}
                        </p>
                    </section>
            @endif
    </div>
@endsection

