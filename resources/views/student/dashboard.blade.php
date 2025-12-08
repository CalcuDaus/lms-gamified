@extends('layouts.app')

@section('content')
    <style>
        @keyframes flame {
            0%, 100% { transform: scale(1) rotate(-2deg); }
            50% { transform: scale(1.1) rotate(2deg); }
        }

        @keyframes countUp {
            from { transform: scale(0.8);  opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .flame-icon {
            animation: flame 1.5s ease-in-out infinite;
        }

        .count-animation {
            animation: countUp 0.6s ease-out;
        }

        .progress-bar-fill {
            transition: width 1s ease-out;
        }
    </style>

    <div class="flex justify-center items-center font-balo max-w-[1400px] flex-col mx-auto p-6">
        {{-- Header Section --}}
        <div class="w-full mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                Welcome back, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Continue your learning journey</p>
        </div>

        {{-- Stats Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full mb-8">
            {{-- XP Progress Card --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-star text-4xl text-purple-600"></i>
                    <span class="text-sm font-semibold bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 px-3 py-1 rounded-full">
                        Level {{ auth()->user()->level }}
                    </span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Total XP</h3>
                <p class="text-4xl font-bold count-animation text-gray-900 dark:text-white">{{ auth()->user()->xp }}</p>
                <div class="mt-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span>Progress</span>
                        <span>{{ auth()->user()->next_level_xp }} XP</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        @php
                            $xpProgress = auth()->user()->next_level_xp > 0 
                                ? (auth()->user()->xp / auth()->user()->next_level_xp) * 100 
                                : 0;
                        @endphp
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-3 rounded-full progress-bar-fill" 
                             style="width: {{ min($xpProgress, 100) }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Streak Card --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-fire flame-icon text-5xl text-orange-600"></i>
                    <span class="text-sm font-semibold bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300 px-3 py-1 rounded-full">
                        Daily
                    </span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Current Streak</h3>
                <p class="text-5xl font-bold count-animation text-gray-900 dark:text-white">{{ auth()->user()->current_streak ?? 0 }}</p>
                <p class="text-sm mt-2">
                    @if(auth()->user()->current_streak > 0)
                        🔥 Keep it going! Don't break the streak!
                    @else
                        Start your streak today!
                    @endif
                </p>
            </div>

            {{-- Completed Quizzes Card --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-trophy text-4xl text-green-600"></i>
                    <span class="text-sm font-semibold bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-3 py-1 rounded-full">
                        Achievement
                    </span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Completed Quizzes</h3>
                <p class="text-5xl font-bold count-animation text-gray-900 dark:text-white">{{ $totalCompletedQuizzes }}</p>
                <p class="text-sm mt-2">
                    {{ $totalCompletedQuizzes > 0 ? 'Great job! 🎉' : 'Start completing quizzes!' }}
                </p>
            </div>

            {{-- Enrolled Courses Card --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-book-open text-4xl text-blue-600"></i>
                    <span class="text-sm font-semibold bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full">
                        Active
                    </span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">My Courses</h3>
                <p class="text-5xl font-bold count-animation text-gray-900 dark:text-white">{{ $enrolledCourses->count() }}</p>
                <p class="text-sm mt-2">
                    {{ $enrolledCourses->count() > 0 ? 'Keep learning! 📚' : 'Enroll in a course!' }}
                </p>
            </div>
        </div>

        {{-- Enrolled Courses Section --}}
        <div class="w-full">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">My Courses</h2>
                <a href="{{ route('student.courses') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all">
                    <i class="fa-solid fa-plus mr-2"></i>Browse Courses
                </a>
            </div>

            @if($enrolledCourses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($enrolledCourses as $index => $course)
                        <div class="flex gap-2 flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                             style="--color-shadow:#9b9b9b;">
                            <img src="https://picsum.photos/seed/{{ $course->id }}/600/400" class="rounded-md" alt="" width="100%">
                            <div class="h-16 overflow-hidden mt-2">
                                <h3 class="font-black text-2xl text-gray-900 dark:text-white">{{ Str::limit($course->title, 35) }}</h3>
                            </div>
                            <p class="text-sm -mt-1">{{ Str::limit($course->description, 70) }}</p>
                            
                            {{-- Progress Bar --}}
                            <div class="mt-2">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500 dark:text-gray-400">Progress</span>
                                    <span class="font-bold">{{ $course->completion_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-1000" 
                                         style="width: {{ $course->completion_percentage }}%"></div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-4">
                                <div class="flex gap-3 text-xs">
                                    <span><i class="fa-solid fa-book mr-1"></i>{{ $course->material->count() }}</span>
                                    <span><i class="fa-solid fa-clipboard-question mr-1"></i>{{ $course->material->sum(fn($m) => $m->quizzes->count()) }}</span>
                                </div>
                                <a href="{{ route('student.courses.learn', $course->id) }}"
                                    class="relative inline-flex active:translate-y-0.5 items-center justify-center px-5 py-2 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-xl group">
                                    @php
                                        $colors = ['orange','red','blue','amber','indigo','green'];
                                    @endphp
                                    <span class="absolute w-0 h-0 transition-all duration-600 ease-out bg-{{ Arr::random($colors)}}-600 rounded-full group-hover:w-56 group-hover:h-56"></span>
                                    <span class="absolute bottom-0 left-0 h-full -ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-full opacity-100 object-stretch" viewBox="0 0 487 487">
                                            <path fill-opacity=".1" fill-rule="nonzero" fill="#FFF"
                                                d="M0 .3c67 2.1 134.1 4.3 186.3 37 52.2 32.7 89.6 95.8 112.8 150.6 23.2 54.8 32.3 101.4 61.2 149.9 28.9 48.4 77.7 98.8 126.4 149.2H0V.3z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="absolute top-0 right-0 w-12 h-full -mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="object-cover w-full h-full" viewBox="0 0 487 487">
                                            <path fill-opacity=".1" fill-rule="nonzero" fill="#FFF"
                                                d="M487 486.7c-66.1-3.6-132.3-7.3-186.3-37s-95.9-85.3-126.2-137.2c-30.4-51.8-49.3-99.9-76.5-151.4C70.9 109.6 35.6 54.8.3 0H487v486.7z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-linear-to-b from-transparent via-transparent to-gray-200"></span>
                                    <span class="relative text-base font-semibold">Continue</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] transition-all duration-300 shadow-custom rounded-3xl p-16 text-center"
                     style="--color-shadow:#9b9b9b;">
                    <i class="fa-solid fa-book-open text-8xl text-gray-300 dark:text-gray-600 mb-6"></i>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">No Courses Yet</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
                        Start your learning journey by enrolling in your first course!
                    </p>
                    <a href="{{ route('student.courses') }}" 
                       class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl font-bold text-lg hover:shadow-2xl transition-all mx-auto">
                        <i class="fa-solid fa-rocket"></i>
                        Explore Courses
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
