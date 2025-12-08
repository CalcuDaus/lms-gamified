@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1400px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $title }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage all your courses</p>
            </div>
            <a href="{{ route('teacher.courses.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all">
                <i class="fa-solid fa-plus mr-2"></i>Create New Course
            </a>
        </div>

        {{-- Courses Grid --}}
        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
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

                        {{-- Student Info --}}
                        @php
                            $enrolledCount = \App\Models\UserProgress::where('course_id', $course->id)->count();
                        @endphp
                        <div class="mt-2">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <i class="fa-solid fa-users"></i>
                                <span>{{ $enrolledCount }} {{ Str::plural('student', $enrolledCount) }} enrolled</span>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('teacher.courses.edit', $course->id) }}"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white text-center rounded-xl font-semibold hover:bg-blue-700 transition-all">
                                <i class="fa-solid fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('teacher.materials.create', $course->id) }}"
                                class="flex-1 px-4 py-2 bg-green-600 text-white text-center rounded-xl font-semibold hover:bg-green-700 transition-all">
                                <i class="fa-solid fa-plus"></i> Material
                            </a>
                            <a href="{{ route('teacher.analytics.course', $course->id) }}"
                                class="px-4 py-2 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition-all">
                                <i class="fa-solid fa-chart-line"></i>
                            </a>
                        </div>

                        {{-- Delete Button --}}
                        <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Are you sure you want to delete this course? This will also delete all materials, quizzes, and questions.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-all">
                                <i class="fa-solid fa-trash mr-1"></i> Delete Course
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] transition-all duration-300 shadow-custom rounded-3xl p-16 text-center w-full"
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
@endsection
