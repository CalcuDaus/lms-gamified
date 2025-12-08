@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1400px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Manage Questions</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $quiz->title }}</p>
            </div>
            <button onclick="history.back()" 
               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back
            </button>
        </div>

        {{-- Add Question Form --}}
        <div class="shadow-custom rounded-3xl p-6 mb-6 w-full">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Add New Question</h3>
            <form action="{{ route('teacher.questions.store', $quiz->id) }}" method="POST" id="questionForm">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-900 dark:text-white font-semibold mb-2">Question Text <span class="text-red-500">*</span></label>
                    <textarea name="question_text" required rows="3"
                              class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"
                              placeholder="Enter your question here..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-900 dark:text-white font-semibold mb-2">Answer Options <span class="text-red-500">*</span></label>
                    <div id="optionsContainer" class="space-y-3">
                        <div class="flex gap-3 items-center option-row">
                            <input type="text" name="options[]" required
                                   class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"
                                   placeholder="Option A">
                            <label class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                <input type="radio" name="correct_answer_index" value="0" required class="w-5 h-5">
                                <span class="text-gray-900 dark:text-white font-semibold">Correct</span>
                            </label>
                        </div>
                        <div class="flex gap-3 items-center option-row">
                            <input type="text" name="options[]" required
                                   class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"
                                   placeholder="Option B">
                            <label class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                <input type="radio" name="correct_answer_index" value="1" required class="w-5 h-5">
                                <span class="text-gray-900 dark:text-white font-semibold">Correct</span>
                            </label>
                        </div>
                        <div class="flex gap-3 items-center option-row">
                            <input type="text" name="options[]" required
                                   class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"
                                   placeholder="Option C">
                            <label class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                <input type="radio" name="correct_answer_index" value="2" required class="w-5 h-5">
                                <span class="text-gray-900 dark:text-white font-semibold">Correct</span>
                            </label>
                        </div>
                        <div class="flex gap-3 items-center option-row">
                            <input type="text" name="options[]" required
                                   class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"
                                   placeholder="Option D">
                            <label class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                <input type="radio" name="correct_answer_index" value="3" required class="w-5 h-5">
                                <span class="text-gray-900 dark:text-white font-semibold">Correct</span>
                            </label>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Select one option as the correct answer</p>
                </div>

                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-xl font-bold hover:shadow-xl transition-all">
                    <i class="fa-solid fa-plus mr-2"></i>Add Question
                </button>
            </form>
        </div>

        {{-- Existing Questions --}}
        <div class="shadow-custom rounded-3xl p-6 w-full">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                Questions ({{ $questions->count() }})
            </h3>

            @if($questions->count() > 0)
                <div class="space-y-4">
                    @foreach($questions as $index => $question)
                        <div class="border-2 border-gray-200 dark:border-gray-700 rounded-2xl p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full font-semibold text-sm">
                                        Question {{ $index + 1 }}
                                    </span>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white mt-2">{{ $question->question_text }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('teacher.questions.edit', $question->id) }}" 
                                       class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <form action="{{ route('teacher.questions.destroy', $question->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this question?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @php
                                    $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                                @endphp
                                @foreach($options as $key => $option)
                                    <div class="flex items-center gap-2 p-3 rounded-xl {{ $key === $question->correct_answer ? 'bg-green-100 dark:bg-green-900 border-2 border-green-500' : 'bg-gray-50 dark:bg-gray-800' }}">
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $key }}.</span>
                                        <span class="text-gray-900 dark:text-white">{{ $option }}</span>
                                        @if($key === $question->correct_answer)
                                            <i class="fa-solid fa-check-circle text-green-600 ml-auto"></i>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-question-circle text-5xl mb-4"></i>
                    <p>No questions yet. Add your first question above!</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Form submission handler to convert options to correct format
        document.getElementById('questionForm').addEventListener('submit', function(e) {
            const options = document.querySelectorAll('input[name="options[]"]');
            const correctIndex = document.querySelector('input[name="correct_answer_index"]:checked');
            
            if (!correctIndex) {
                e.preventDefault();
                alert('Please select the correct answer!');
                return;
            }

            // Create hidden input for correct_answer with the letter (A, B, C, D)
            const letters = ['A', 'B', 'C', 'D', 'E', 'F'];
            const correctAnswerInput = document.createElement('input');
            correctAnswerInput.type = 'hidden';
            correctAnswerInput.name = 'correct_answer';
            correctAnswerInput.value = letters[correctIndex.value];
            this.appendChild(correctAnswerInput);
        });
    </script>
@endsection
