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
    <div class="flex justify-center items-center">
        {{-- Card Section --}}
        <section class="flex max-w-[936px] w-full h-[250px] justify-between items-end">
            <div class="flex w-[288px] h-[148px] rounded-3xl items-center  justify-center overflow-hidden shadow-custom" style="--color-shadow:#ff4136; ">
                <div class="p-6 flex flex-col text-[#ff4036] items-center relative justify-center ">
                    <h3 class="text-xl font-semibold mb-2"> Courses</h3>
                    <p class="text-5xl font-black">10</p>
                    <i class="fa-solid fa-fire text-[#ff4036a9] animate-bounce absolute text-[85px] z-1 -bottom-10 -right-[100px] blur-[1px] "></i>
                </div>
            </div>
            <div class="flex w-[288px] h-[148px] text-[#00aa4a] rounded-3xl items-center relative overflow-hidden -translate-y-10 justify-center shadow-custom" style="--color-shadow:#00aa49; ">
                <div class="p-6 flex flex-col items-center justify-center">
                    <h3 class="text-xl font-semibold mb-2">Completed Courses</h3>
                    <p class="text-5xl font-black">9</p>
                    <i class="fa-solid fa-book text-[#00aa4aa6] animate-bounce absolute text-[85px] z-1 -bottom-8 -right-5 blur-[1px] "></i>
                </div>
            </div>
            <div class="flex w-[288px] text-[#0074d9] h-[148px] rounded-3xl items-center relative overflow-hidden justify-center shadow-custom" style="--color-shadow:#0074d9; ">
                <div class="p-6 flex flex-col items-center justify-center">
                    <h3 class="text-xl font-semibold mb-2">Badges</h3>
                    <p class="text-5xl  font-black">22</p>
                    <i class="fa-solid fa-award text-[#0074d9b2] animate-bounce absolute text-[85px] z-1 -bottom-6 -right-[19px] blur-[1px] "></i>
                </div>
            </div>

        </section>
    </div>
@endsection
