<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\QuizService;
use App\Services\UserQuizAttempsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    protected $quizService;
    protected $quizAttempsService;

    public function __construct(
        QuizService $quizService,
        UserQuizAttempsService $quizAttempsService
    ) {
        $this->quizService = $quizService;
        $this->quizAttempsService = $quizAttempsService;
    }

    public function start($quizId)
    {
        $quiz = $this->quizService->getQuizById($quizId);
        $data = [
            'title' => 'Take Quiz: ' . $quiz->title,
            'quiz' => $quiz,
        ];
        return view('student.start-quiz', $data);
    }

    public function submit(Request $request, $quizId)
    {
        $userId = Auth::id();
        $answers = $request->input('answers', []);
        
        $attempt = $this->quizAttempsService->submitQuizAttempt($userId, $quizId, $answers);
        
        return redirect()->route('student.quiz.results', $attempt->id);
    }

    public function results($attemptId)
    {
        $attempt = $this->quizAttempsService->getQuizResults($attemptId);
        
        if (!$attempt) {
            abort(404, 'Quiz attempt not found.');
        }
        
        $data = [
            'title' => 'Quiz Results',
            'attempt' => $attempt,
        ];
        return view('student.quiz-results', $data);
    }
}
