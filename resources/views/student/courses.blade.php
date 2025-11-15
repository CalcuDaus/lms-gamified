@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] flex-col mx-auto">
        <section title="Search Bar" class="w-full dark:text-[#d6d6d6]">
            <div class="w-full flex justify-center  ">
                <input type="text" placeholder="Search courses..."
                    class="sm:w-1/2 w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none"
                    style="--color-shadow:#9b9b9b;">
                <i
                    class="fa-solid fa-magnifying-glass translate-y-3.5 -translate-x-10 right-0 text-gray-600 dark:text-[#d6d6d6] "></i>
            </div>
        </section>

        <section class="flex w-full justify-center gap-7 mt-10 flex-wrap">
            @forelse ($courses as $course)
                <div class="flex gap-2 min-w-3xs max-w-[300px] flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                    style="--color-shadow:#9b9b9b;">
                    <img src="https://picsum.photos/id/237/600/400" class="rounded-md" alt="" width="100%">
                    <div class="h-16 overflow-hidden mt-2 ">
                        <h3 class="font-black text-2xl">{{ Str::limit($course->title,35) }}</h3>
                    </div>
                    <p class="text-sm -mt-1">{{ Str::limit($course->description,70) }}</p>
                    <p class="text-[12px] -mt-1 text-gray-500">By {{ Str::ucfirst($course->user->name) }}</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="font-bold text-lg">Free</span>
                        <a href="{{ route('student.courses.show', $course->id) }}"
                            class="relative inline-flex active:translate-y-0.5 items-center justify-center px-5 py-2 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-xl group">
                            <span
                                class="absolute w-0 h-0 transition-all duration-600 ease-out bg-green-600 rounded-full group-hover:w-56 group-hover:h-56"></span>
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
                            <span class="relative text-base font-semibold">View course</span>
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 dark:text-[#9b9b9b]">No courses found</p>
            @endforelse
        </section>
    </div>
@endsection
