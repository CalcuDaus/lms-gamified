@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">
        <div class="flex justify-between w-full mb-4">
            <a href="{{ route('quizzes.show', $question->quiz_id) }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-[#848484] text-[12px]">
                <i class="fa-solid fa-chevron-left text-[10px]"></i> Back to Quiz
            </a>
        </div>

        <div class="w-3/4 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Question Details</h2>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-semibold">Question Text</label>
                <p class="p-3 bg-gray-100 dark:bg-gray-700 rounded-md">{{ $question->question_text }}</p>
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-semibold">Options</label>
                <div class="space-y-2">
                    @foreach ($question->options as $key => $option)
                        <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center gap-2">
                            <span class="font-bold">{{ $key }}:</span>
                            <span>{{ $option }}</span>
                            @if ($key === $question->correct_answer)
                                <span class="ml-auto text-green-600 font-bold"><i class="fa-solid fa-check"></i>
                                    Correct</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-semibold">Correct Answer</label>
                <p class="p-3 bg-green-100 dark:bg-green-900 rounded-md font-bold">{{ $question->correct_answer }}</p>
            </div>

            <div class="flex gap-2 mt-6">
                <a href="{{ route('questions.edit', $question->id) }}"
                    class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">
                    <i class="fa-solid fa-edit"></i> Edit Question
                </a>
                <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        <i class="fa-solid fa-trash"></i> Delete Question
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
