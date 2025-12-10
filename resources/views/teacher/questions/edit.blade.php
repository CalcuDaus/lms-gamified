@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1200px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Edit Question</h1>
                <p class="text-gray-600 dark:text-gray-400">Update question details</p>
            </div>
            <button onclick="history.back()" 
               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back
            </button>
        </div>

        {{-- Edit Form --}}
        <div class="shadow-custom rounded-3xl p-8 w-full">
            <form action="{{ route('teacher.questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Question Text <span class="text-red-500">*</span>
                    </label>
                    <textarea name="question_text" required rows="3"
                              class="w-full px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                              style="--color-shadow:#9b9b9b;">{{ $question->question_text }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Answer Options <span class="text-red-500">*</span>
                    </label>
                    @php
                        $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                        $optionKeys = array_keys($options);
                    @endphp
                    <div class="space-y-3">
                        @foreach($options as $key => $option)
                            <div class="flex gap-3 items-center">
                                <input type="text" name="options[]" required value="{{ $option }}"
                                       class="flex-1 px-4 pt-3 pb-2 rounded-3xl shadow-custom focus:outline-none text-gray-900 dark:text-white bg-white dark:bg-gray-800"
                                       style="--color-shadow:#9b9b9b;"
                                       placeholder="Option {{ $key }}">
                                <label class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                    <input type="radio" name="correct_answer_index" value="{{ array_search($key, $optionKeys) }}" 
                                           {{ $key === $question->correct_answer ? 'checked' : '' }} required class="w-5 h-5">
                                    <span class="text-gray-900 dark:text-white font-semibold">Correct</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="px-8 py-4 bg-linear-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl transition-all">
                        <i class="fa-solid fa-save mr-2"></i>Update Question
                    </button>
                    <button type="button" onclick="history.back()"
                       class="px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-bold text-lg hover:shadow-lg transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form submission handler
        document.querySelector('form').addEventListener('submit', function(e) {
            const correctIndex = document.querySelector('input[name="correct_answer_index"]:checked');
            
            if (!correctIndex) {
                e.preventDefault();
                alert('Please select the correct answer!');
                return;
            }

            // Create hidden input for correct_answer
            const letters = ['A', 'B', 'C', 'D', 'E', 'F'];
            const correctAnswerInput = document.createElement('input');
            correctAnswerInput.type = 'hidden';
            correctAnswerInput.name = 'correct_answer';
            correctAnswerInput.value = letters[correctIndex.value];
            this.appendChild(correctAnswerInput);
        });
    </script>
@endsection
