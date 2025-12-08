@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">
        <div class="flex justify-between w-full mb-4">
            <a href="{{ route('quizzes.show', $question->quiz_id) }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-[#848484] text-[12px]">
                <i class="fa-solid fa-chevron-left text-[10px]"></i> Back to Quiz
            </a>
        </div>

        <form action="{{ route('questions.update', $question->id) }}" method="POST" class="flex flex-col gap-4 w-3/4">
            @csrf
            @method('PUT')

            <input type="hidden" name="quiz_id" value="{{ $question->quiz_id }}">

            <div>
                <label class="block mb-1 text-sm">Question Text</label>
                <textarea name="question_text" rows="3"
                    class="w-full p-2 rounded-md bg-transparent border-2 border-gray-500 text-gray-500 dark:text-white"
                    required>{{ $question->question_text }}</textarea>
            </div>

            <div>
                <label class="block mb-1 text-sm">Options</label>
                <div class="space-y-2">
                    @foreach ($question->options as $key => $value)
                        <div class="flex gap-2">
                            <input type="text" value="{{ $key }}" readonly
                                class="w-12 p-2 rounded-md bg-gray-200 dark:bg-gray-700 text-center">
                            <input type="text" name="options[{{ $key }}]" value="{{ $value }}"
                                class="flex-1 p-2 rounded-md bg-transparent border-2 border-gray-500 text-gray-500 dark:text-white"
                                required>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block mb-1 text-sm">Correct Answer</label>
                <select name="correct_answer"
                    class="w-full p-2 rounded-md bg-transparent border-2 border-gray-500 text-gray-500 dark:text-white"
                    required>
                    @foreach ($question->options as $key => $value)
                        <option value="{{ $key }}" {{ $question->correct_answer === $key ? 'selected' : '' }}>
                            {{ $key }} - {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-[#848484] text-[14px] mt-3">
                Update Question
            </button>
        </form>
    </div>
@endsection
