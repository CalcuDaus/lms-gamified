<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizRequest;
use App\Services\QuizService;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index()
    {
        $data = [
            'title' => 'Quizzes Management',
            'quizzes' => $this->quizService->getAllQuizzes(),
        ];
        return view('admin.quizzes.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Quiz',
            'materials' => $this->quizService->getAllMaterials(),
        ];
        return view('admin.quizzes.create', $data);
    }

    public function store(QuizRequest $request)
    {
        $this->quizService->createQuiz($request->validated());
        return redirect()->route('materials.index')->with('success', 'Quiz created successfully.');
    }

    public function show(string $id)
    {
        $data = [
            'title' => 'Quiz Detail',
            'quiz' => $this->quizService->getQuizById($id),
        ];
        return view('admin.quizzes.detail', $data);
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Quiz',
            'quiz' => $this->quizService->getQuizById($id),
            'materials' => $this->quizService->getAllMaterials()
        ];
        return view('admin.quizzes.edit', $data);
    }

    public function update(QuizRequest $request, string $id)
    {
        $this->quizService->updateQuiz($id, $request->validated());
        return redirect()->route('quizzes.show', $id)->with('success', 'Quiz updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->quizService->deleteQuiz($id);
        return redirect()->route('materials.index')->with('success', 'Quiz deleted successfully.');
    }
}
