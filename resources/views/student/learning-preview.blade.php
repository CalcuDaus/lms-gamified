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
            <a href="{{ route('student.courses.learn', $course->id) }}"
                class="relative inline-flex  items-center justify-center px-5 py-2 overflow-hidden tracking-tighter text-white bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl group">
                <span
                    class="absolute w-0 h-0 transition-all duration-600 ease-out bg-green-700 rounded-full group-hover:w-56 group-hover:h-56"></span>
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
                <span class="relative text-base font-semibold"><i class="fa-solid fa-play mr-2"></i>Start Learning</span>
            </a>

        </section>
        {{-- Detail Course --}}
        <section class="flex gap-5 mt-5">
            <div class="flex gap-2 flex-wrap justify-between w-[35%] h-max items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-4 relative overflow-hidden"
                style="--color-shadow:#9b9b9b;">
                <div class="w-full p-2 ">
                    <img src="https://picsum.photos/id/237/600/400" class="rounded-2xl" alt="{{ $course->title }}"
                        class="w-full h-full">
                </div>
                <div class="w-full flex flex-col h-[\-webkit-fill-available] pt-2 px-2 justify-between">
                    <p>{{ $course->description }}</p>
                    <div class="flex items-center  gap-2.5 my-2">
                        <img src="https://www.pngall.com/wp-content/uploads/5/Profile-Male-PNG.png" alt=""
                            width="40px" class="rounded-full">
                        <h3 class="font-bold">{{ $course->user->name }}</h3>
                    </div>
                    <div class="flex justify-between">
                        <p class="font-bold text-end">{{ $course->created_at->diffForHumans() }}</p>
                        <p class="font-black text-green-100  text-end text-xl z-1">{{ $course->material->sum('xp_reward') }}
                            Xp</p>
                        <i
                            class="fa-solid fa-award text-green-700  absolute text-[285px] -z-1 -bottom-52 -right-[195px]  "></i>
                    </div>
                </div>
            </div>
            <div class="w-[65%] h-[650px]  text-gray-600 dark:text-[#EEEEEE] p-6 scrollbar overflow-auto shadow-custom rounded-3xl"
                style="--color-shadow:#9b9b9b;">
                <div class="flex p-5 w-full flex-wrap gap-5">
                    @php
                        $colors = [
                            '#dc2626', // red-600
                            '#ea580c', // orange-600
                            '#d97706', // amber-600
                            '#ca8a04', // yellow-600
                            '#65a30d', // lime-600
                            '#16a34a', // green-600
                            '#059669', // emerald-600
                            '#0d9488', // teal-600
                            '#0891b2', // cyan-600
                            '#0284c7', // sky-600
                            '#2563eb', // blue-600
                            '#4f46e5', // indigo-600
                            '#7c3aed', // violet-600
                            '#9333ea', // purple-600
                            '#c026d3', // fuchsia-600
                            '#db2777', // pink-600
                            '#e11d48', // rose-600
                        ];
                        $marginTop = 0;
                    @endphp
                    @foreach ($course->material as $index => $material)
                        @php
                            $randomColor = $colors[array_rand($colors)];
                        @endphp <div id="tooltipLearning" data-tippy-content="{{ $material->title }}"
                            class="flex cursor-pointer justify-center flex-col w-14 h-max items-center shadow-custom rounded-full p-4"
                            style="--color-shadow: {{ $randomColor }};margin-top: {{ $index * 20 }}px;">
                            <span class="font-bold ">{{ $loop->iteration }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
