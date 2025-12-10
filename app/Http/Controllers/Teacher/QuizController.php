<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\MaterialService;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    protected $materialService;
    protected $quizService;

    public function __construct(
        MaterialService $materialService,
        QuizService $quizService
    ) {
        $this->materialService = $materialService;
        $this->quizService = $quizService;
    }

    public function create($materialId)
    {
        $material = $this->materialService->getMaterialById($materialId);
        $course = $material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $data = [
            'title' => 'Create Quiz',
            'material' => $material,
        ];
        return view('teacher.quizzes.create', $data);
    }

    public function store(Request $request, $materialId)
    {
        $material = $this->materialService->getMaterialById($materialId);
        $course = $material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'xp_reward' => 'required|integer|min:0',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);
        
        $validated['material_id'] = $materialId;
        
        $quiz = $this->quizService->createQuiz($validated);
        return redirect()->route('teacher.questions.manage', $quiz->id)->with('success', 'Quiz created! Now add questions.');
    }

    public function edit($id)
    {
        $quiz = $this->quizService->getQuizById($id);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $data = [
            'title' => 'Edit Quiz',
            'quiz' => $quiz,
        ];
        return view('teacher.quizzes.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $quiz = $this->quizService->getQuizById($id);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'xp_reward' => 'required|integer|min:0',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);
        
        $this->quizService->updateQuiz($id, $validated);
        return redirect()->route('teacher.courses.index')->with('success', 'Quiz updated successfully!');
    }

    public function destroy($id)
    {
        $quiz = $this->quizService->getQuizById($id);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $this->quizService->deleteQuiz($id);
        return redirect()->back()->with('success', 'Quiz deleted successfully!');
    }
}
