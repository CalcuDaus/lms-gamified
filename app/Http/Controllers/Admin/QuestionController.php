<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        $data = [
            'title' => 'Questions Management',
            'questions' => $this->questionService->getAllQuestions(),
        ];
        return view('admin.questions.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Question',
        ];
        return view('admin.questions.create', $data);
    }

    public function store(QuestionRequest $request)
    {
        $this->questionService->createQuestion($request->validated());
        return redirect()->route('quizzes.show', $request->quiz_id)->with('success', 'Question created successfully.');
    }

    public function show(string $id)
    {
        $data = [
            'title' => 'Question Detail',
            'question' => $this->questionService->getQuestionById($id),
        ];
        return view('admin.questions.show', $data);
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Question',
            'question' => $this->questionService->getQuestionById($id),
        ];
        return view('admin.questions.edit', $data);
    }

    public function update(QuestionRequest $request, string $id)
    {
        $this->questionService->updateQuestion($id, $request->validated());
        $question = $this->questionService->getQuestionById($id);
        return redirect()->route('quizzes.show', $question->quiz_id)->with('success', 'Question updated successfully.');
    }

    public function destroy(string $id)
    {
        $question = $this->questionService->getQuestionById($id);
        $quizId = $question->quiz_id;
        $this->questionService->deleteQuestion($id);
        return redirect()->route('quizzes.show', $quizId)->with('success', 'Question deleted successfully.');
    }
}
