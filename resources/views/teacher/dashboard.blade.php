@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1400px] flex-col mx-auto p-6">
        {{-- Header Section --}}
        <div class="w-full mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                Teacher Dashboard 👨‍🏫
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Manage your courses and monitor student progress</p>
        </div>

        {{-- Stats Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full mb-8">
            {{-- Total Courses Card --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-book text-4xl text-blue-600"></i>
                    <span class="text-sm font-semibold bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full">
                        Active
                    </span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">My Courses</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $courses->count() }}</p>
                <p class="text-sm mt-2">
                    {{ $courses->count() > 0 ? 'Keep creating! 📚' : 'Create your first course!' }}
                </p>
            </div>

            {{-- Total Students Card --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-users text-4xl text-green-600"></i>
                    <span class="text-sm font-semibold bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-3 py-1 rounded-full">
                        Enrolled
                    </span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Total Students</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $totalStudents }}</p>
                <p class="text-sm mt-2">
                    {{ $totalStudents > 0 ? 'Great reach! 🎯' : 'No students yet' }}
                </p>
            </div>

            {{-- Quick Actions Card --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-rocket text-4xl text-purple-600"></i>
                    <span class="text-sm font-semibold bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 px-3 py-1 rounded-full">
                        Actions
                    </span>
                </div>
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Quick Actions</h3>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('teacher.courses.create') }}" 
                       class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all text-center">
                        <i class="fa-solid fa-plus mr-2"></i>New Course
                    </a>
                    <a href="{{ route('teacher.courses.index') }}" 
                       class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all text-center">
                        <i class="fa-solid fa-list mr-2"></i>View All Courses
                    </a>
                </div>
            </div>
        </div>

        {{-- My Courses Section --}}
        <div class="w-full">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">My Courses</h2>
                <a href="{{ route('teacher.courses.create') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all">
                    <i class="fa-solid fa-plus mr-2"></i>Create Course
                </a>
            </div>

            @if($courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($courses as $course)
                        <div class="flex gap-2 flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                             style="--color-shadow:#9b9b9b;">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="rounded-md object-cover h-48" alt="{{ $course->title }}" width="100%">
                            @else
                                <img src="https://picsum.photos/seed/{{ $course->id }}/600/400" class="rounded-md object-cover h-48" alt="{{ $course->title }}" width="100%">
                            @endif
                            <div class="h-16 overflow-hidden mt-2">
                                <h3 class="font-black text-2xl text-gray-900 dark:text-white">{{ Str::limit($course->title, 35) }}</h3>
                            </div>
                            <p class="text-sm -mt-1">{{ Str::limit($course->description, 70) }}</p>
                            
                            <div class="flex justify-between items-center mt-2 text-xs">
                                <span><i class="fa-solid fa-book mr-1"></i>{{ $course->material->count() }} Materials</span>
                                <span><i class="fa-solid fa-clipboard-question mr-1"></i>{{ $course->material->sum(fn($m) => $m->quizzes->count()) }} Quizzes</span>
                            </div>

                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('teacher.courses.edit', $course->id) }}"
                                    class="flex-1 px-4 py-2 bg-blue-600 text-white text-center rounded-xl font-semibold hover:bg-blue-700 transition-all">
                                    <i class="fa-solid fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('teacher.materials.create', $course->id) }}"
                                    class="flex-1 px-4 py-2 bg-green-600 text-white text-center rounded-xl font-semibold hover:bg-green-700 transition-all">
                                    <i class="fa-solid fa-plus"></i> Add Material
                                </a>
                                <a href="{{ route('teacher.analytics.course', $course->id) }}"
                                    class="px-4 py-2 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition-all">
                                    <i class="fa-solid fa-chart-line"></i>
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
                        Create your first course and start teaching!
                    </p>
                    <a href="{{ route('teacher.courses.create') }}" 
                       class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl font-bold text-lg hover:shadow-2xl transition-all mx-auto">
                        <i class="fa-solid fa-rocket"></i>
                        Create First Course
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
