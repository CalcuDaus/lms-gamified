<?php

namespace App\Services;

use App\Models\Quiz;
use App\Repositories\QuizRepository;
use App\Repositories\MaterialRepository;
use Illuminate\Database\Eloquent\Collection;

class QuizService
{
    /**
     * Create a new class instance.
     */
    protected $quizRepository;
    protected $materialRepository;
    public function __construct(QuizRepository $quizRepository, MaterialRepository $materialRepository)
    {
        $this->quizRepository = $quizRepository;
        $this->materialRepository = $materialRepository;
    }

    public function getAllQuizzes(): Collection
    {
        return $this->quizRepository->getAllQuizzes();
    }

    public function getAllMaterials(): Collection
    {
        return $this->materialRepository->getAllMaterials();
    }
    public function getQuizById($id): ?Quiz
    {
        return $this->quizRepository->getQuizById($id);
    }

    public function createQuiz($data): Quiz
    {
        return $this->quizRepository->createQuiz($data);
    }

    public function updateQuiz($id, $data): bool
    {
        return $this->quizRepository->updateQuiz($id, $data);
    }

    public function deleteQuiz($data): ?bool
    {
        return $this->quizRepository->deleteQuiz($data);
    }
}
