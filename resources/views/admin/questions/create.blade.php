@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">
        <div class="flex justify-between w-full mb-4">
            <a href="{{ route('quizzes.show', request('quiz_id')) }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-[#848484] text-[12px]">
                <i class="fa-solid fa-chevron-left text-[10px]"></i> Back
            </a>
        </div>

        <div class="w-3/4">
            <h2 class="text-2xl font-bold mb-6">Questions are managed via Quiz Detail</h2>
            <p class="text-gray-500 mb-4">Please use the "Add Question" button on the Quiz Detail page to create questions.</p>
            <a href="{{ route('materials.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Go to Materials & Quizzes
            </a>
        </div>
    </div>
@endsection
