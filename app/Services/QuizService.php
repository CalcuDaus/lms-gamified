<?php

namespace App\Services;

use App\Repositories\MaterialRepository;

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

    public function getAllQuizzes()
    {
        return $this->quizRepository->getAllQuizzes();
    }

    public function getAllMaterials()
    {
        return $this->materialRepository->getAllMaterials();
    }
    public function getQuizById($id)
    {
        return $this->quizRepository->getQuizById($id);
    }

    public function createQuiz($data)
    {
        return $this->quizRepository->createQuiz($data);
    }

    public function updateQuiz($id, $data)
    {
        return $this->quizRepository->updateQuiz($id, $data);
    }

    public function deleteQuiz($data)
    {
        return $this->quizRepository->deleteQuiz($data);
    }
}
