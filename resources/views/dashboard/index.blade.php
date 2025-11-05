@extends('layouts.app')
@push('styles')
    <style>
        @layer utilities {
            .shadow-custom:hover {
                box-shadow:
                    inset 4px 4px 10px  var(--color-shadow),
                    1px 4px 4px -1px var(--color-shadow);
            }
            .shadow-custom {
                transition: box-shadow 0.3s ease;
                box-shadow:
                    inset 2px 2px 10px  var(--color-shadow),
                    1px 1px 2px -1px var(--color-shadow);
            }
        }
    </style>
@endpush
@section('content')
    <div class="flex justify-center items-center font-balo max-w-[936px] flex-col mx-auto">
        {{-- Card Section --}}
        <section class="flex w-full mt-10 justify-between items-end">
            <div class="flex w-[288px] h-[148px] rounded-3xl items-center  justify-center overflow-hidden shadow-custom" style="--color-shadow:#ff4136; ">
                <div class="p-6 flex flex-col text-[#ff4036] items-center relative justify-center ">
                    <h3 class="text-2xl font-black mb-2"> Courses</h3>
                    <p class="text-6xl font-black">10</p>
                    <i style="animation-delay: 400ms" class="fa-solid fa-fire text-[#ff4036a9] animate-bounce absolute text-[85px] z-1 -bottom-10 -right-[100px] blur-[1px] "></i>
                </div>
            </div>
            <div class="flex w-[288px] h-[148px] text-[#00aa4a] rounded-3xl items-center relative overflow-hidden -translate-y-10 justify-center shadow-custom" style="--color-shadow:#00aa49; ">
                <div class="p-6 flex flex-col items-center justify-center">
                    <h3 class="text-2xl font-black mb-2">Completed Courses</h3>
                    <p class="text-6xl font-black">9</p>
                    <i style="animation-delay: 300ms" class="fa-solid fa-book text-[#00aa4aa6] animate-bounce absolute text-[85px] z-1 -bottom-8 -right-5 blur-[1px] "></i>
                </div>
            </div>
            <div class="flex w-[288px] text-[#0074d9] h-[148px] rounded-3xl items-center relative overflow-hidden justify-center shadow-custom" style="--color-shadow:#0074d9; ">
                <div class="p-6 flex flex-col items-center justify-center">
                    <h3 class="text-2xl font-black mb-2">Badges</h3>
                    <p class="text-6xl  font-black">22</p>
                    <i style="animation-delay: 200ms" class="fa-solid fa-award text-[#0074d9b2] animate-bounce absolute text-[85px] z-1 -bottom-6 -right-[19px] blur-[1px] "></i>
                </div>
            </div>

        </section>
        <section class="flex w-full mt-10">
            <div class="flex w-[55%] flex-col gap-6" >
                {{-- Widget Progress --}}
                <div class="flex gap-2 flex-col text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6" style="--color-shadow:#9b9b9b;">
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
                        
                            <button
                                class="ml-auto px-4 py-2 shadow-custom text-sm text-gray-600 font-bold dark:text-white rounded-md hover:bg-green-500 transition-all duration-500 "  style="--color-shadow:#00aa49; ">
                                Claim Rewards
                            </button>
                    </div>
                </div>
                {{-- Widget Log Activity --}}
                <div class="flex gap-2 flex-col text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6" style="--color-shadow:#9b9b9b;">
                    <h3 class="font-black text-2xl ">Recent Activity</h3>
                    <p class="text-red-500">There is no recent activity</p>
                </div>
            </div>
            <div class="flex w-[45%] ps-6">
                {{-- Widget Leaderboards --}}
                <div class="flex gap-2 w-full flex-col text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6" style="--color-shadow:#9b9b9b;">
                    <h3 class="font-black text-2xl ">Leaderboards</h3>
                    <p class="text-red-500">There is no leaderboards</p>
                </div>
            </div>
        </section>
    </div>
@endsection
