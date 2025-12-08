<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} - LMS Gamified</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes celebration {
            0% { transform: scale(0) rotate(0deg); }
            50% { transform: scale(1.2) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }

        .question-enter {
            animation: slideInUp 0.5s ease-out;
        }

        .option-hover:hover {
            animation: pulse 0.3s ease-in-out;
        }

        .correct-answer {
            animation: bounce 0.6s ease-in-out;
        }

        .wrong-answer {
            animation: shake 0.5s ease-in-out;
        }

        .progress-bar-animate {
            transition: width 0.5s ease-out;
        }

        .celebration-icon {
            animation: celebration 0.8s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-900 dark:to-gray-800 font-sans antialiased min-h-screen">
    {{-- Top Progress Bar - Duolingo Style --}}
    <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 sticky top-0 z-50 shadow-md">
        <div id="progressBar" class="h-full bg-gradient-to-r from-green-400 via-green-500 to-emerald-600 progress-bar-animate rounded-r-full transition-all duration-500"
            style="width: 0%"></div>
    </div>

    <div class="max-w-2xl mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('student.courses.learn', $quiz->material->course_id) }}"
                class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-all">
                <i class="fa-solid fa-times text-2xl"></i>
            </a>

            <div class="flex items-center gap-4">
                <div class="text-sm text-gray-600 dark:text-gray-400 font-bold">
                    <span id="currentQuestion">1</span> / {{ $quiz->questions->count() }}
                </div>
                <div class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full font-bold shadow-lg">
                    <i class="fa-solid fa-star mr-1"></i>{{ $quiz->xp_reward }} XP
                </div>
            </div>
        </div>

        {{-- Quiz Title Card --}}
        <div id="titleCard" class="mb-8 text-center question-enter">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white mb-4 shadow-2xl">
                <i class="fa-solid fa-brain text-5xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $quiz->title }}</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">{{ $quiz->questions->count() }} Questions</p>
            <button onclick="startQuiz()" 
                class="mt-6 px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl font-bold text-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all">
                <i class="fa-solid fa-play mr-2"></i>Start Quiz
            </button>
        </div>

        {{-- Quiz Container --}}
        <div id="quizContainer" class="hidden">
            <form id="quizForm">
                @csrf
                @foreach ($quiz->questions as $index => $question)
                    <div class="question-card hidden" data-question="{{ $index }}">
                        {{-- Question Text --}}
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 mb-6 question-enter">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                                        {{ $question->question_text }}
                                    </h3>

                                    {{-- Options --}}
                                    <div class="space-y-3">
                                        @php
                                            $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                                        @endphp
                                        @foreach ($options as $optionKey => $optionValue)
                                            <label class="option-card option-hover block">
                                                <input type="radio" 
                                                    name="answers[{{ $question->id }}]" 
                                                    value="{{ $optionKey }}"
                                                    class="hidden option-input"
                                                    data-question-index="{{ $index }}"
                                                    required>
                                                <div class="option-content flex items-center gap-4 p-5 rounded-2xl border-3 border-gray-300 dark:border-gray-600 cursor-pointer transition-all hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:shadow-lg">
                                                    <div class="option-circle w-8 h-8 rounded-full border-3 border-gray-400 dark:border-gray-500 flex items-center justify-center">
                                                        <div class="option-dot w-0 h-0 rounded-full bg-blue-600 transition-all"></div>
                                                    </div>
                                                    <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                                        {{ $optionKey }}. {{ $optionValue }}
                                                    </span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-4">
                            @if ($index > 0)
                                <button type="button" onclick="previousQuestion()" 
                                    class="px-6 py-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-2xl font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                                    <i class="fa-solid fa-chevron-left mr-2"></i>Back
                                </button>
                            @endif
                            
                            @if ($index < $quiz->questions->count() - 1)
                                <button type="button" onclick="nextQuestion()" 
                                    class="flex-1 px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl font-bold hover:shadow-xl hover:scale-105 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="nextBtn{{ $index }}" disabled>
                                    Continue<i class="fa-solid fa-chevron-right ml-2"></i>
                                </button>
                            @else
                                <button type="button" onclick="submitQuiz()" 
                                    class="flex-1 px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-2xl font-bold hover:shadow-xl hover:scale-105 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="submitBtn" disabled>
                                    <i class="fa-solid fa-check-circle mr-2"></i>Submit Quiz
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </form>
        </div>

        {{-- Timer Display (if applicable) --}}
        @if ($quiz->time_limit)
            <div id="timerDisplay" class="hidden fixed top-20 right-4 bg-gradient-to-r from-red-500 to-orange-600 text-white px-6 py-3 rounded-2xl shadow-2xl font-bold text-xl z-40">
                <i class="fa-solid fa-clock mr-2"></i><span id="timerText">{{ $quiz->time_limit }}:00</span>
            </div>
        @endif
    </div>

    <script>
        let currentQuestion = 0;
        const totalQuestions = {{ $quiz->questions->count() }};
        let timeLeft = {{ $quiz->time_limit ?? 0 }} * 60;

        function startQuiz() {
            document.getElementById('titleCard').classList.add('hidden');
            document.getElementById('quizContainer').classList.remove('hidden');
            showQuestion(0);
            
            @if ($quiz->time_limit)
                document.getElementById('timerDisplay').classList.remove('hidden');
                startTimer();
            @endif

            // Success sound
            playSound('start');
        }

        function showQuestion(index) {
            document.querySelectorAll('.question-card').forEach(card => card.classList.add('hidden'));
            const questionCard = document.querySelector(`[data-question="${index}"]`);
            questionCard.classList.remove('hidden');
            questionCard.classList.add('question-enter');
            
            currentQuestion = index;
            updateProgress();
            document.getElementById('currentQuestion').textContent = index + 1;
        }

        function nextQuestion() {
            if (currentQuestion < totalQuestions - 1) {
                showQuestion(currentQuestion + 1);
                playSound('next');
            }
        }

        function previousQuestion() {
            if (currentQuestion > 0) {
                showQuestion(currentQuestion - 1);
                playSound('back');
            }
        }

        function updateProgress() {
            const progress = ((currentQuestion + 1) / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
        }

        // Handle option selection
        document.querySelectorAll('.option-input').forEach(input => {
            input.addEventListener('change', function() {
                const questionIndex = this.dataset.questionIndex;
                const nextBtn = document.getElementById('nextBtn' + questionIndex);
                const submitBtn = document.getElementById('submitBtn');
                
                // Enable next/submit button
                if (nextBtn) nextBtn.disabled = false;
                if (submitBtn) submitBtn.disabled = false;

                // Visual feedback
                const optionCard = this.closest('.option-card');
                const allOptions = optionCard.closest('.space-y-3').querySelectorAll('.option-card');
                
                allOptions.forEach(opt => {
                    opt.querySelector('.option-content').classList.remove('border-blue-600', 'bg-blue-100', 'dark:bg-blue-900');
                    opt.querySelector('.option-dot').classList.remove('w-4', 'h-4');
                });

                const content = optionCard.querySelector('.option-content');
                content.classList.add('border-blue-600', 'bg-blue-100', 'dark:bg-blue-900', 'correct-answer');
                optionCard.querySelector('.option-dot').classList.add('w-4', 'h-4');
                
                playSound('select');
            });
        });

        function submitQuiz() {
            Swal.fire({
                title: 'Submit Quiz?',
                text: 'Are you ready to submit your answers?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit!',
                cancelButtonText: 'Review Answers',
                confirmButtonColor: '#10b981',
                customClass: {
                    popup: 'rounded-3xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Grading your quiz...',
                        html: '<i class="fa-solid fa-spinner fa-spin text-6xl text-blue-600"></i>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    // Submit form
                    document.getElementById('quizForm').action = "{{ route('student.quiz.submit', $quiz->id) }}";
                    document.getElementById('quizForm').method = 'POST';
                    document.getElementById('quizForm').submit();
                }
            });
        }

        @if ($quiz->time_limit)
        function startTimer() {
            setInterval(() => {
                if (timeLeft <= 0) {
                    submitQuiz();
                    return;
                }
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById('timerText').textContent = 
                    `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                // Warning color when < 1 minute
                if (timeLeft < 60) {
                    document.getElementById('timerDisplay').classList.add('animate-pulse');
                }
            }, 1000);
        }
        @endif

        function playSound(type) {
            // You can add actual sound effects here
            console.log('Sound:', type);
        }

        // Show first question on load
        // startQuiz(); // Uncomment to auto-start
    </script>
</body>

</html>
