@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1400px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                    {{  __('messages.' . strtolower(str_replace(' ', '_', $title))) }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ __('messages.manage_all_courses') }}</p>
                </div>
                <a href="{{ route('teacher.courses.create') }}"
                    class="px-6 py-3 bg-linear-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all">
                    <i class="fa-solid fa-plus mr-2"></i>{{ __('messages.create_new_course') }}
                </a>
                </div>

                {{-- Courses Grid --}}
                @if($courses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
                        @foreach($courses as $course)
                            <div class="flex gap-2 flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                                style="--color-shadow:#9b9b9b;">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="rounded-md object-cover h-48"
                                        alt="{{ $course->title }}" width="100%" loading="lazy">
                                @else
                                    <img src="https://picsum.photos/seed/{{ $course->id }}/600/400" class="rounded-md object-cover h-48"
                                        alt="{{ $course->title }}" width="100%" loading="lazy">
                                @endif
                                <div class="h-16 overflow-hidden mt-2">
                                    <h3 class="font-black text-2xl text-gray-900 dark:text-white">{{ Str::limit($course->title, 35) }}</h3>
                                </div>
                                <p class="text-sm -mt-1">{{ Str::limit($course->description, 70) }}</p>

                                <div class="flex justify-between items-center mt-2 text-xs">
                                    <span><i class="fa-solid fa-book mr-1"></i>{{ $course->material->count() }}
                                        {{ __('messages.materials') }}</span>
                                    <span><i
                                            class="fa-solid fa-clipboard-question mr-1"></i>{{ $course->material->sum(fn($m) => $m->quizzes->count()) }}
                                        {{ __('messages.quizzes') }}</span>
                                </div>

                                {{-- Student Info --}}
                                @php
                                    $enrolledCount = \App\Models\UserProgress::where('course_id', $course->id)->count();
                                @endphp
                                <div class="mt-2">
                                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fa-solid fa-users"></i>
                                        <span>{{ $enrolledCount }} {{ $enrolledCount == 1 ? __('messages.student') : __('messages.students') }}
                                            {{ __('messages.enrolled') }}</span>
                                    </div>
                                </div>


                                <div class="grid grid-cols-2 gap-2 mt-4">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('teacher.courses.edit', $course->id) }}"
                                        class="relative inline-flex active:translate-y-0.5 items-center justify-center px-4 py-2.5 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-xl group">
                                        @php
                                            $colors = ['red', 'blue', 'amber', 'indigo', 'green'];
                                        @endphp
                                        <span
                                            class="absolute w-0 h-0 transition-all duration-500 ease-out bg-{{ Arr::random($colors)}}-600 rounded-full group-hover:w-56 group-hover:h-56"></span>
                                        <span class="absolute bottom-0 left-0 h-full -ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-full opacity-100 object-stretch"
                                                viewBox="0 0 487 487">
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
                                        <span
                                            class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-linear-to-b from-transparent via-transparent to-gray-200"></span>
                                        <span class="relative text-sm font-semibold"><i class="fa-solid fa-edit mr-1"></i>
                                            {{ __('messages.edit') }}</span>
                                    </a>

                                    {{-- Add Material Button --}}
                                    <a href="{{ route('teacher.materials.create', $course->id) }}"
                                        class="relative inline-flex active:translate-y-0.5 items-center justify-center px-4 py-2.5 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-xl group">
                                        <span
                                            class="absolute w-0 h-0 transition-all duration-500 ease-out bg-{{ Arr::random($colors)}}-600 rounded-full group-hover:w-56 group-hover:h-56"></span>
                                        <span class="absolute bottom-0 left-0 h-full -ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-full opacity-100 object-stretch"
                                                viewBox="0 0 487 487">
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
                                        <span
                                            class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-linear-to-b from-transparent via-transparent to-gray-200"></span>
                                        <span class="relative text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i>
                                            {{ __('messages.material') }}</span>
                                    </a>

                                    {{-- Analytics Button --}}
                                    <a href="{{ route('teacher.analytics.course', $course->id) }}"
                                        class="relative inline-flex active:translate-y-0.5 items-center justify-center px-4 py-2.5 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-xl group">
                                        <span
                                            class="absolute w-0 h-0 transition-all duration-500 ease-out bg-{{ Arr::random($colors)}}-600 rounded-full group-hover:w-56 group-hover:h-56"></span>
                                        <span class="absolute bottom-0 left-0 h-full -ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-full opacity-100 object-stretch"
                                                viewBox="0 0 487 487">
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
                                        <span
                                            class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-linear-to-b from-transparent via-transparent to-gray-200"></span>
                                        <span class="relative text-sm font-semibold"><i class="fa-solid fa-chart-line mr-1"></i>
                                            {{ __('messages.analytics') }}</span>
                                    </a>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST"
                                        onsubmit="return confirm('{{ __('messages.delete_course_confirm') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full relative inline-flex active:translate-y-0.5 items-center justify-center px-4 py-2.5 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-xl group">
                                            <span
                                                class="absolute w-0 h-0 transition-all duration-500 ease-out bg-red-600 rounded-full group-hover:w-56 group-hover:h-56"></span>
                                            <span class="absolute bottom-0 left-0 h-full -ml-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-full opacity-100 object-stretch"
                                                    viewBox="0 0 487 487">
                                                    <path fill-opacity=".1" fill-rule="nonzero" fill="#FFF"
                                                        d="M0 .3c67 2.1 134.1 4.3 186.3 37 52.2 32.7 89.6 95.8 112.8 150.6 23.2 54.8 32.3 101.4 61.2 149.9 28.9 48.4 77.7 98.8 126.4 149.2H0V.3z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <span class="absolute top-0 right-0 w-12 h-full -mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="object-cover w-full h-full"
                                                    viewBox="0 0 487 487">
                                                    <path fill-opacity=".1" fill-rule="nonzero" fill="#FFF"
                                                        d="M487 486.7c-66.1-3.6-132.3-7.3-186.3-37s-95.9-85.3-126.2-137.2c-30.4-51.8-49.3-99.9-76.5-151.4C70.9 109.6 35.6 54.8.3 0H487v486.7z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <span
                                                class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-linear-to-b from-transparent via-transparent to-gray-200"></span>
                                            <span class="relative text-sm font-semibold"><i class="fa-solid fa-trash mr-1"></i>
                                                {{ __('messages.delete') }}</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                        {{-- Empty State --}}
                        <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] transition-all duration-300 shadow-custom rounded-3xl p-16 text-center w-full"
                            style="--color-shadow:#9b9b9b;">
                            <i class="fa-solid fa-book-open text-8xl text-gray-300 dark:text-gray-600 mb-6"></i>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{__('messages.no_courses_yet') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
                                {{ __('messages.create_your_first_course') }}
                            </p>
                            <a href="{{ route('teacher.courses.create') }}"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-linear-to-r from-blue-600 to-purple-600 text-white rounded-2xl font-bold text-lg hover:shadow-2xl transition-all mx-auto">
                                <i class="fa-solid fa-rocket"></i>
                                {{ __('messages.create_first_course') }}
                        </a>
                    </div>
                @endif
    </div>
@endsection
