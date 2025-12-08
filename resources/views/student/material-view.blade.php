<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $material->title }} - LMS Gamified</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased">
    {{-- Clean Duolingo-style layout --}}
    <div class="min-h-screen flex flex-col">
        {{-- Top Progress Bar --}}
        <div class="w-full h-2 bg-gray-200 dark:bg-gray-800">
            <div class="h-full bg-gradient-to-r from-green-500 to-emerald-600 transition-all duration-500"
                style="width: {{ $progress }}%"></div>
        </div>

        {{-- Header - Minimal --}}
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
            <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
                <a href="{{ route('student.courses.learn', $course->id) }}"
                    class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="font-semibold">Back to Course</span>
                </a>

                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <i class="fa-solid fa-book-open mr-1"></i>
                        Material {{ $materialIndex + 1 }}/{{ $totalMaterials }}
                    </div>
                    <div
                        class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full font-bold text-sm shadow-md">
                        <i class="fa-solid fa-star mr-1"></i>{{ $material->xp_reward }} XP
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content Area - Centered and Clean --}}
        <main class="flex-1 py-12 px-4">
            <div class="max-w-3xl mx-auto">
                {{-- Material Title --}}
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r 
                        {{ $gradients[$materialIndex % count($gradients)]['from'] }} 
                        {{ $gradients[$materialIndex % count($gradients)]['to'] }} 
                        text-white font-bold text-3xl shadow-lg mb-4">
                        {{ $materialIndex + 1 }}
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">{{ $material->title }}</h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400">{{ $course->title }}</p>
                </div>

                {{-- Content Card - Clean and Spacious --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 md:p-12 mb-8 border border-gray-100 dark:border-gray-700">
                    
                    {{-- Video Player Section --}}
                    @if ($material->video_url ?? false)
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-video text-red-500"></i>
                                Watch & Learn
                            </h3>
                            <div class="relative rounded-2xl overflow-hidden shadow-lg" style="padding-top: 56.25%;">
                                <iframe 
                                    class="absolute top-0 left-0 w-full h-full"
                                    src="{{ $material->video_url }}" 
                                    title="Learning Video"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 text-center">
                                <i class="fa-solid fa-lightbulb mr-1"></i>
                                Watch the video before reading the material for best results!
                            </p>
                        </div>
                    @endif

                    {{-- Material Content --}}
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        {!! nl2br(e($material->content)) !!}
                    </div>

                    {{-- Visual Separator --}}
                    @if ($material->file || count($material->quizzes) > 0)
                        <div class="my-8 border-t border-gray-200 dark:border-gray-700"></div>
                    @endif

                    {{-- Additional Resources --}}
                    @if ($material->file)
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                                <i class="fa-solid fa-paperclip mr-2 text-blue-500"></i>Attachments
                            </h3>
                            <a href="{{ Storage::url($material->file) }}" target="_blank"
                                class="inline-flex items-center gap-3 px-6 py-3 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-800 transition-all">
                                <i class="fa-solid fa-download"></i>
                                <span class="font-semibold">Download Material Resources</span>
                            </a>
                        </div>
                    @endif

                    {{-- Related Quizzes --}}
                    @if (count($material->quizzes) > 0)
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                                <i class="fa-solid fa-clipboard-question mr-2 text-purple-500"></i>Test Your Knowledge
                            </h3>
                            <div class="space-y-3">
                                @foreach ($material->quizzes as $quiz)
                                    @php
                                        $hasPassed = $userAttempts->contains(function ($attempt) use ($quiz) {
                                            return $attempt->quiz_id === $quiz->id && $attempt->passed;
                                        });
                                    @endphp

                                    <div
                                        class="flex items-center justify-between p-5 rounded-2xl border-2 transition-all hover:shadow-lg
                                        {{ $hasPassed ? 'bg-green-50 dark:bg-green-900/20 border-green-500' : 'bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600' }}">
                                        <div class="flex items-center gap-4">
                                            @if ($hasPassed)
                                                <i class="fa-solid fa-circle-check text-3xl text-green-600"></i>
                                            @else
                                                <i class="fa-solid fa-circle text-3xl text-gray-400"></i>
                                            @endif
                                            <div>
                                                <h4 class="font-bold text-lg text-gray-900 dark:text-white">
                                                    {{ $quiz->title }}</h4>
                                                <div class="flex gap-3 text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    <span><i class="fa-solid fa-clock mr-1"></i>{{ $quiz->time_limit }}
                                                        min</span>
                                                    <span><i
                                                            class="fa-solid fa-check-double mr-1"></i>{{ $quiz->passing_score }}%</span>
                                                    <span><i
                                                            class="fa-solid fa-star mr-1"></i>{{ $quiz->xp_reward }}
                                                        XP</span>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($hasPassed)
                                            <span
                                                class="px-5 py-2 bg-green-600 text-white rounded-xl font-bold shadow-md">
                                                <i class="fa-solid fa-trophy mr-2"></i>Completed
                                            </span>
                                        @else
                                            <a href="{{ route('student.quiz.start', $quiz->id) }}"
                                                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-bold hover:shadow-xl transition-all">
                                                <i class="fa-solid fa-play mr-2"></i>Start Quiz
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Navigation Buttons - Duolingo Style --}}
                <div class="flex gap-4">
                    @if ($previousMaterial)
                        <a href="{{ route('student.material.view', $previousMaterial->id) }}"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-2xl font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                            <i class="fa-solid fa-chevron-left"></i>
                            <span>Previous</span>
                        </a>
                    @endif

                    @if ($nextMaterial)
                        <button onclick="showChallenge()"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl font-bold hover:shadow-xl transition-all">
                            <span>Continue</span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    @else
                        <a href="{{ route('student.courses.learn', $course->id) }}"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl font-bold hover:shadow-xl transition-all">
                            <span>Complete & Return</span>
                            <i class="fa-solid fa-check-circle"></i>
                        </a>
                    @endif
                </div>
            </div>
        </main>

        {{-- Footer - Minimal --}}
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-4">
            <div class="max-w-4xl mx-auto px-4 text-center text-sm text-gray-500 dark:text-gray-400">
                Keep learning! 🚀 You're doing great!
            </div>
        </footer>
    </div>

    {{-- Challenge System Script --}}
    @if ($nextMaterial)
        <script>
            const challenges = [
                {
                    question: "Quick Check! What did you learn from this material?",
                    options: ["{{ $material->title }}", "Something else", "I don't remember", "Skip"],
                    correct: 0,
                    hint: "Think about the main topic we just covered!"
                },
                {
                    question: "Are you ready to continue to the next material?",
                    options: ["Yes, I understood everything!", "Let me review first", "I need help", "Continue anyway"],
                    correct: 0,
                    hint: "Make sure you're comfortable before moving on!"
                },
                {
                    question: "What's the best way to learn this material?",
                    options: ["Watch video + read content + practice", "Just read quickly", "Skip to quiz", "Copy paste"],
                    correct: 0,
                    hint: "Active learning works best!"
                }
            ];

            function showChallenge() {
                const challenge = challenges[Math.floor(Math.random() * challenges.length)];
                
                Swal.fire({
                    title: '<i class="fa-solid fa-brain text-purple-500"></i> Quick Challenge!',
                    html: `
                        <div class="text-left">
                            <p class="text-lg font-semibold mb-4">${challenge.question}</p>
                            <div class="space-y-2">
                                ${challenge.options.map((option, index) => `
                                    <button onclick="checkAnswer(${index}, ${challenge.correct})" 
                                            class="w-full p-3 text-left rounded-lg border-2 border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-all challenge-option">
                                        <span class="font-semibold">${String.fromCharCode(65 + index)}.</span> ${option}
                                    </button>
                                `).join('')}
                            </div>
                            <p class="text-sm text-gray-500 mt-4">
                                <i class="fa-solid fa-lightbulb mr-1"></i> Hint: ${challenge.hint}
                            </p>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCloseButton: true,
                    width: '600px',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
            }

            function checkAnswer(selected, correct) {
                if (selected === correct) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Excellent! 🎉',
                        html: '<p class="text-lg">You earned <strong class="text-yellow-600">+10 XP</strong>!</p>',
                        confirmButtonText: 'Continue Learning',
                        confirmButtonColor: '#10b981',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = "{{ route('student.material.view', $nextMaterial->id) }}";
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Not quite!',
                        text: 'Review the material and try again, or continue anyway.',
                        showCancelButton: true,
                        confirmButtonText: 'Continue Anyway',
                        cancelButtonText: 'Review Material',
                        confirmButtonColor: '#3b82f6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('student.material.view', $nextMaterial->id) }}";
                        }
                    });
                }
            }
        </script>
    @endif
</body>

</html>
