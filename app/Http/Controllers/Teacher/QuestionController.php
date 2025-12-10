<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\QuizService;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index($quizId)
    {
        $quiz = $this->quizService->getQuizById($quizId);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        // Get all questions for this quiz
        $questions = $quiz->questions;
        
        $data = [
            'title' => 'Manage Questions - ' . $quiz->title,
            'quiz' => $quiz,
            'questions' => $questions,
        ];
        return view('teacher.questions.manage', $data);
    }

    public function store(Request $request, $quizId)
    {
        $quiz = $this->quizService->getQuizById($quizId);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string',
        ]);
        
        $validated['quiz_id'] = $quizId;
        
        Question::create($validated);
        return redirect()->back()->with('success', 'Question added successfully!');
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $data = [
            'title' => 'Edit Question',
            'question' => $question,
            'quiz' => $quiz,
        ];
        return view('teacher.questions.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string',
        ]);
        
        $question->update($validated);
        return redirect()->route('teacher.questions.manage', $quiz->id)->with('success', 'Question updated successfully!');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $quizId = $quiz->id;
        $question->delete();
        return redirect()->route('teacher.questions.manage', $quizId)->with('success', 'Question deleted successfully!');
    }
}
