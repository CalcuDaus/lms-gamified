@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1400px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $student->email }}</p>
                </div>
            </div>
            <button onclick="history.back()" 
               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back
            </button>
        </div>

        {{-- Student Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full mb-8">
            {{-- Level --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-trophy text-4xl text-yellow-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Level</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $student->level }}</p>
            </div>

            {{-- Total XP --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-star text-4xl text-purple-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Total XP</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $student->xp }}</p>
            </div>

            {{-- Courses Enrolled --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-book text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Courses Enrolled</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $progress->count() }}</p>
            </div>

            {{-- Current Streak --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-fire text-4xl text-orange-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Streak</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $student->current_streak ?? 0 }}</p>
            </div>
        </div>

        {{-- Course Progress --}}
        <div class="shadow-custom rounded-3xl p-6 w-full mb-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Course Progress in Your Courses</h3>
            @if($progress->count() > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach($progress as $enrollment)
                        @php
                            $course = $enrollment->course;
                            $totalQuizzes = $course->material->sum(fn($m) => $m->quizzes->count());
                            $quizIds = $course->material->flatMap(fn($m) => $m->quizzes->pluck('id'));
                            $passedQuizzes = \App\Models\UserQuizAttemps::where('user_id', $student->id)
                                ->where('passed', true)
                                ->whereIn('quiz_id', $quizIds)
                                ->distinct('quiz_id')
                                ->count();
                            $completionRate = $totalQuizzes > 0 ? round(($passedQuizzes / $totalQuizzes) * 100) : 0;
                        @endphp
                        <div class="flex items-center justify-between p-4 border-2 border-gray-200 dark:border-gray-700 rounded-2xl hover:border-blue-500 transition-all">
                            <div class="flex-1">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $course->title }}</h4>
                                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                    <span><i class="fa-solid fa-clipboard-question mr-1"></i>{{ $passedQuizzes }}/{{ $totalQuizzes }} Quizzes Passed</span>
                                    <span><i class="fa-solid fa-book mr-1"></i>{{ $course->material->count() }} Materials</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $completionRate }}%</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Completion</p>
                                </div>
                                <div class="w-32">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full transition-all duration-1000" 
                                             style="width: {{ $completionRate }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">Not enrolled in any of your courses yet</p>
            @endif
        </div>

        {{-- Quiz Attempts --}}
        <div class="shadow-custom rounded-3xl p-6 w-full">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Quiz Attempts</h3>
            @php
                // Get all quiz attempts from this student in teacher's courses
                $quizAttempts = \App\Models\UserQuizAttemps::where('user_id', $student->id)
                    ->whereHas('quiz.material.course', function($query) {
                        $query->where('created_by', auth()->id());
                    })
                    ->with(['quiz.material.course'])
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
            @endphp
            
            @if($quizAttempts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 px-4 text-gray-900 dark:text-white font-semibold">Course</th>
                                <th class="text-left py-3 px-4 text-gray-900 dark:text-white font-semibold">Quiz</th>
                                <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-semibold">Score</th>
                                <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-semibold">Status</th>
                                <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-semibold">XP Earned</th>
                                <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-semibold">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quizAttempts as $attempt)
                                <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                    <td class="py-4 px-4 text-gray-900 dark:text-white">
                                        {{ $attempt->quiz->material->course->title }}
                                    </td>
                                    <td class="py-4 px-4 text-gray-900 dark:text-white">
                                        {{ $attempt->quiz->title }}
                                    </td>
                                    <td class="text-center py-4 px-4">
                                        <span class="text-lg font-bold {{ $attempt->score >= 80 ? 'text-green-600' : ($attempt->score >= 70 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $attempt->score }}%
                                        </span>
                                    </td>
                                    <td class="text-center py-4 px-4">
                                        @if($attempt->passed)
                                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full font-semibold">
                                                <i class="fa-solid fa-check mr-1"></i>Passed
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-full font-semibold">
                                                <i class="fa-solid fa-times mr-1"></i>Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center py-4 px-4">
                                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-full font-semibold">
                                            +{{ $attempt->xp_earned }} XP
                                        </span>
                                    </td>
                                    <td class="text-center py-4 px-4 text-gray-600 dark:text-gray-400 text-sm">
                                        {{ $attempt->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">No quiz attempts yet</p>
            @endif
        </div>
    </div>
@endsection
