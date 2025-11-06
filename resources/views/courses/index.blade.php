@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[936px] flex-col mx-auto">
        <section title="Search Bar" class="w-full dark:text-[#d6d6d6]">
            <div class="w-full flex justify-center mt-10  ">
                <input type="text" placeholder="Search courses..."
                    class="sm:w-1/2 w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none"
                    style="--color-shadow:#9b9b9b;">
                <i
                    class="fa-solid fa-magnifying-glass translate-y-3.5 -translate-x-10 right-0 text-gray-600 dark:text-[#d6d6d6] "></i>
            </div>
        </section>
        <section class="flex w-full mt-10">
            <div class="flex w-[55%] flex-col gap-6">
                {{-- Widget Progress --}}
                <div class="flex gap-2 flex-col text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6"
                    style="--color-shadow:#9b9b9b;">
                    <h3 class="font-black text-2xl ">Progress & XP</h3>
                    <div class="w-full h-3 bg-gray-400 rounded-full mt-2 overflow-hidden">
                        <div class="h-3 from-[#094b00] animate-pulse to-[#00d45c] bg-linear-to-r rounded-full w-3/4"></div>
                    </div>
                    <p class="text-end text-sm text-gray-500">350/500 XP</p>
                    <h3 class="font-bold">Level Junior</h3>
                    <div class="flex">
                        <div class="badges">
                            <i class="fa-solid fa-medal text-yellow-500"></i>
                            <i class="fa-solid fa-medal text-yellow-500"></i>
                            <i class="fa-solid fa-medal text-yellow-500"></i>
                            {{-- <img src="{{ asset('assets/img/badge1.png') }}" alt="Badge 1" class="w-12 h-12 mr-2"> --}}
                            {{-- <img src="{{ asset('assets/img/badge2.png') }}" alt="Badge 2" class="w-12 h-12 mr-2"> --}}
                            {{-- <img src="{{ asset('assets/img/badge3.png') }}" alt="Badge 3" class="w-12 h-12 mr-2"> --}}
                        </div>

                        <!-- From Uiverse.io by Mubashir222 -->
                        <button
                            class="relative inline-flex items-center justify-center px-5 py-2 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-md group">
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
                            <span class="relative text-base font-semibold">Take this course</span>
                        </button>

                    </div>
                </div>
                {{-- Widget Log Activity --}}
                <div class="flex gap-2 flex-col text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6"
                    style="--color-shadow:#9b9b9b;">
                    <h3 class="font-black text-2xl ">Recent Activity</h3>
                    <p class="text-red-500">There is no recent activity</p>
                </div>
            </div>
            <div class="flex w-[45%] ps-6">
                {{-- Widget Leaderboards --}}
                <div class="flex gap-2 w-full flex-col text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6"
                    style="--color-shadow:#9b9b9b;">
                    <h3 class="font-black text-2xl ">Leaderboards</h3>
                    <p class="text-red-500">There is no leaderboards</p>
                </div>
            </div>
        </section>
    </div>
@endsection
