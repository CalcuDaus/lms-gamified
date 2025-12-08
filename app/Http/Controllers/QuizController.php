<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Laravel\Sail\Console\PublishCommand;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Create Quiz',
            'materials' => $this->quizService->getAllMaterials(),
        ];
        return view('admin.quizzes.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizRequest $request)
    {
        $this->quizService->createQuiz($request->validated());
        return redirect()->route('materials.index')->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'title' => 'Quiz Detail',
            'quiz' => $this->quizService->getQuizById($id),
        ];
        return view('admin.quizzes.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Quiz',
            'quiz' => $this->quizService->getQuizById($id),
            'materials' => $this->quizService->getAllMaterials()
        ];
        return view('admin.quizzes.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizRequest $request, string $id)
    {
        $this->quizService->updateQuiz($id, $request->validated());
        return redirect()->route('quizzes.show', $id)->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->quizService->deleteQuiz($id);
        return redirect()->route('materials.index')->with('success', 'Quiz deleted successfully.');
    }
}
