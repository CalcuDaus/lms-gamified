@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">
        <div class="flex justify-between w-full">
            <a href="{{ route('materials.index') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-[#848484] text-[12px]">
                <i class="fa-solid fa-chevron-left text-[10px]"></i>

                Back</a>
            <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-[#848484] text-[12px]">
                    <i class="fa-solid fa-trash text-[10px]"></i>
                    Delete Quiz

                </button>
            </form>
        </div>

        <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST" class="flex flex-col gap-4 w-3/4">
            @csrf
            @method('PUT')

            <div>
                <input type="hidden" name="material_id" value="{{ $quiz->material_id }}">
            </div>

            <div>
                <label class="block mb-1 text-sm">Title</label>
                <input type="text" name="title" value="{{ $quiz->title }}"
                    class="w-full p-2 rounded-md bg-transparent border-2 border-gray-500 text-gray-500 dark:text-white"
                    required>
            </div>

            <div>
                <label class="block mb-1 text-sm">XP Reward</label>
                <input type="number" name="xp_reward" value="{{ $quiz->xp_reward }}"
                    class="w-full p-2 rounded-md bg-transparent border-2 border-gray-500 text-gray-500 dark:text-white">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm">Time Limit (minutes)</label>
                    <input type="number" name="time_limit" value="{{ $quiz->time_limit }}"
                        class="w-full p-2 rounded-md bg-transparent border-2 border-gray-500 text-gray-500 dark:text-white">
                </div>

                <div>
                    <label class="block mb-1 text-sm">Passing Score (%)</label>
                    <input type="number" name="passing_score" value="{{ $quiz->passing_score }}"
                        class="w-full p-2 rounded-md bg-transparent border-2 border-gray-500 text-gray-500 dark:text-white">
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-[#848484] text-[14px] mt-3">
                Update Quiz
            </button>
        </form>
        <a href="#" id="AddQuestion"
            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-[#848484] text-[14px] mt-3">
            <i class="fa-solid text-[10px] me-2 fa-plus"></i>
            Add Question
        </a>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const AddQuestion = document.getElementById('AddQuestion');

                AddQuestion.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Add Question',
                        html: `
                       <form action="{{ route('questions.store') }}" method="POST" class="flex flex-col gap-4">
    @csrf

    <input type="text" name="question_text" placeholder="Question" class="w-full p-2 rounded-md border">

    <!-- Dynamic Options -->
    <div id="options-wrapper" class="flex flex-col gap-3">
        <div class="flex gap-2">
            <input type="text" name="options[A]" placeholder="Option A" class="flex-1 border p-2 rounded-md">
        </div>
        <div class="flex gap-2">
            <input type="text" name="options[B]" placeholder="Option B" class="flex-1 border p-2 rounded-md">
        </div>
        <div class="flex gap-2">
            <input type="text" name="options[C]" placeholder="Option C" class="flex-1 border p-2 rounded-md">
        </div>
        <div class="flex gap-2">
            <input type="text" name="options[D]" placeholder="Option D" class="flex-1 border p-2 rounded-md">
        </div>
    </div>

    <!-- Correct Answer -->
    <input type="text" name="correct_answer" placeholder="Correct Answer (A/B/C/D)" class="w-full p-2 rounded-md border">

    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

    <button type="button" onclick="addOption()" class="bg-blue-500 text-white px-3 py-1 rounded-md">
    + Add Option
</button>

    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md mt-3">
        Save Question
    </button>
</form>

                        `,
                        showCloseButton: true,
                        showConfirmButton: false,
                    })
                });
            });

            let optionIndex = 4;

            function addOption() {
                const wrapper = document.getElementById('options-wrapper');
                const letter = String.fromCharCode(65 + optionIndex); // A B C D E ...
                const html = `
        <div class="flex gap-2">
            <input type="text" name="options[${letter}]" placeholder="Option ${letter}" class="flex-1 border p-2 rounded-md">
        </div>
    `;
                wrapper.insertAdjacentHTML('beforeend', html);
                optionIndex++;
            }
        </script>
    @endpush
@endsection
