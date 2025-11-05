@extends('layouts.app')
@push('styles')
    <style>
        @layer utilities {
            .shadow-custom {
                box-shadow:
                    inset 0 2px 6px var(--color-shadow),
                    0 4px 8px var(--color-shadow);
            }
        }
    </style>
@endpush
@section('content')
    <div class="flex justify-center items-center">
        {{-- Card Section --}}
        <section class="flex h-[250px] justify-between">
            <div class="flex w-[288px] rounded-3xl items-center justify-center shadow-custom" style="--color-shadow:#00aa49; ">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">Total Courses</h3>
                    <p class="text-3xl font-bold">12</p>
                </div>
            </div>

        </section>
    </div>
@endsection
