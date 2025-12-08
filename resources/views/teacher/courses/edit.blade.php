@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1400px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Edit Course</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $course->title }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('teacher.analytics.course', $course->id) }}" 
                   class="px-6 py-3 bg-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all">
                    <i class="fa-solid fa-chart-line mr-2"></i>Analytics
                </a>
                <a href="{{ route('teacher.courses.index') }}" 
                   class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>

        {{-- Course Details Form --}}
        <div class="shadow-custom rounded-3xl p-6 mb-6 w-full">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Course Details</h3>
            <form action="{{ route('teacher.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-900 dark:text-white font-semibold mb-2">Course Title</label>
                        <input type="text" name="title" value="{{ $course->title }}" required
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-900 dark:text-white font-semibold mb-2">Course Thumbnail</label>
                        <input type="file" name="thumbnail" accept="image/*"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-gray-900 dark:text-white font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3" required
                              class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">{{ $course->description }}</textarea>
                </div>
                <button type="submit" class="mt-4 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all">
                    <i class="fa-solid fa-save mr-2"></i>Update Course
                </button>
            </form>
        </div>

        {{-- Materials Section --}}
        <div class="shadow-custom rounded-3xl p-6 mb-6 w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Course Materials</h3>
                <a href="{{ route('teacher.materials.create', $course->id) }}" 
                   class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-all">
                    <i class="fa-solid fa-plus mr-2"></i>Add Material
                </a>
            </div>

            @if($course->material->count() > 0)
                <div class="space-y-4">
                    @foreach($course->material as $material)
                        <div class="border-2 border-gray-200 dark:border-gray-700 rounded-2xl p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $material->title }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ Str::limit($material->content, 150) }}</p>
                                    <div class="flex gap-3 text-sm text-gray-600 dark:text-gray-400">
                                        <span><i class="fa-solid fa-award text-yellow-500 mr-1"></i>{{ $material->xp_reward }} XP</span>
                                        <span><i class="fa-solid fa-clipboard-question text-blue-500 mr-1"></i>{{ $material->quizzes->count() }} Quizzes</span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('teacher.materials.edit', $material->id) }}" 
                                       class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <a href="{{ route('teacher.quizzes.create', $material->id) }}" 
                                       class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all">
                                        <i class="fa-solid fa-plus"></i> Quiz
                                    </a>
                                    <form action="{{ route('teacher.materials.destroy', $material->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Delete this material?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Quizzes for this material --}}
                            @if($material->quizzes->count() > 0)
                                <div class="mt-4 pl-6 border-l-4 border-purple-500 space-y-3">
                                    @foreach($material->quizzes as $quiz)
                                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <h5 class="text-lg font-bold text-gray-900 dark:text-white">{{ $quiz->title }}</h5>
                                                    <div class="flex gap-4 text-sm text-gray-600 dark:text-gray-400 mt-2">
                                                        <span><i class="fa-solid fa-clock mr-1"></i>{{ $quiz->time_limit }} min</span>
                                                        <span><i class="fa-solid fa-percentage mr-1"></i>{{ $quiz->passing_score }}% passing</span>
                                                        <span><i class="fa-solid fa-star mr-1"></i>{{ $quiz->xp_reward }} XP</span>
                                                        <span><i class="fa-solid fa-question mr-1"></i>{{ $quiz->questions->count() }} questions</span>
                                                    </div>
                                                </div>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('teacher.questions.manage', $quiz->id) }}" 
                                                       class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all">
                                                        <i class="fa-solid fa-list-check"></i> Questions
                                                    </a>
                                                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" 
                                                       class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('teacher.quizzes.destroy', $quiz->id) }}" method="POST" class="inline"
                                                          onsubmit="return confirm('Delete this quiz?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-book-open text-5xl mb-4"></i>
                    <p>No materials yet. Add your first material to get started!</p>
                </div>
            @endif
        </div>

        {{-- Delete Course Section --}}
        <div class="shadow-custom rounded-3xl p-6 w-full border-2 border-red-200 dark:border-red-900">
            <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-2">Danger Zone</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Deleting this course will remove all materials, quizzes, and questions. This action cannot be undone.</p>
            <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" 
                  onsubmit="return confirm('Are you absolutely sure? This will delete everything!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-all">
                    <i class="fa-solid fa-trash mr-2"></i>Delete Entire Course
                </button>
            </form>
        </div>
    </div>
@endsection
