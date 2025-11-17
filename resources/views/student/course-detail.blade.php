@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] flex-col mx-auto">
        {{-- Header --}}
        <section
            class="flex gap-2 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-4"
            style="--color-shadow:#9b9b9b;">
            <a href="{{ route('student.courses') }}"
                class="relative inline-flex  items-center justify-center px-5 py-2 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-xl group">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="object-cover w-full h-full" viewBox="0 0 487 487">
                        <path fill-opacity=".1" fill-rule="nonzero" fill="#FFF"
                            d="M487 486.7c-66.1-3.6-132.3-7.3-186.3-37s-95.9-85.3-126.2-137.2c-30.4-51.8-49.3-99.9-76.5-151.4C70.9 109.6 35.6 54.8.3 0H487v486.7z">
                        </path>
                    </svg>
                </span>
                <span
                    class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-linear-to-b from-transparent via-transparent to-gray-200"></span>
                <span class="relative text-base font-semibold"><i class="fa-solid fa-arrow-left"></i> Back</span>
            </a>
            <h1 class="text-xl font-bold text-gray-600 dark:text-[#EEEEEE]">{{ $course->title }}</h1>
            <button
                class="relative inline-flex  items-center justify-center px-5 py-2 overflow-hidden tracking-tighter text-white bg-rose-600 rounded-xl group">
                <span
                    class="absolute w-0 h-0 transition-all duration-600 ease-out bg-sky-400 rounded-full group-hover:w-56 group-hover:h-56"></span>
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
                <span class="relative text-base font-semibold">Take Course</span>
            </button>
        </section>
        {{-- Detail Course --}}
        <section class="flex gap-5 mt-5">
            <div class="flex gap-2 justify-between w-[65%] h-max items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-4"
                style="--color-shadow:#9b9b9b;">
                <div class="w-[55%] p-2 ">
                    <img src="https://picsum.photos/id/237/600/400" class="rounded-2xl" alt="{{ $course->title }}"
                        class="w-full h-full">
                </div>
                <div class="w-[45%] flex flex-col h-[\-webkit-fill-available] pt-2 justify-between">
                    <p>{{ $course->description }}</p>
                    <p class="font-bold text-end">{{ $course->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="flex gap-2 justify-center flex-col w-[35%] h-max items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-4"
                style="--color-shadow:#9b9b9b;">
                <h2 class="text-xl font-bold text-gray-600 dark:text-[#EEEEEE]">Profile Teacher</h2>
                <img src="https://www.pngall.com/wp-content/uploads/5/Profile-Male-PNG.png" alt="" width="100px"
                    class="rounded-full">
                <h3 class="font-bold">{{ $course->user->name }}</h3>
                <p>{{ $course->user->bio }}</p>
            </div>
        </section>
        <section class="flex flex-col w-full gap-5 mt-5">
            <button type="button"
                class="relative inline-flex w-max items-center justify-center px-5 py-2 overflow-hidden tracking-tighter text-white bg-violet-800 rounded-xl group">
                <span
                    class="absolute w-0 h-0 transition-all duration-600 ease-out bg-yellow-600 rounded-full group-hover:w-56 group-hover:h-56"></span>
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
                <span class="relative text-base font-semibold"><i class="fa-solid fa-list text-[12px] me-2"></i>List of
                    Materials</span>
            </button>
            @forelse ($course->material as $material)
                <div class="flex gap-5 w-full">
                    <div class="flex  justify-center flex-col w-13 h-max items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-2xl p-3"
                        style="--color-shadow:#9b9b9b;">
                        <span class="font-bold ">{{ $loop->iteration }}</span>
                    </div>
                    <div class="flex  justify-center flex-col w-full h-max items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-2xl p-3"
                        style="--color-shadow:#9b9b9b;">
                        <span>{{ Str::limit($material->title,100) }}</span>
                    </div>
                </div>
            @empty
                    <div class="flex  justify-center flex-col w-full h-max items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-2xl p-3"
                        style="--color-shadow:#9b9b9b;">
                        <span class="font-bold ">No Materials yet</span>
                    </div>
            @endforelse
        </section>
    </div>
@endsection
