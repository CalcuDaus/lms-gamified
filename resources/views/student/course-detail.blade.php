@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] flex-col mx-auto">
        {{ $course->title }}
        @foreach ($course->material as $material )
        <p class="text-red-500">{{ $material->title }}</p>
        @endforeach
    </div>
@endsection
