<?php

namespace App\Repositories;

class QuizRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllQuizzes()
    {
        return Quiz::all();
    }

    public function getQuizById($id)
    {
        return Quiz::find($id);
    }
    public function createQuiz($data)
    {
        return Quiz::create($data);
    }

    public function updateQuiz($id, $data)
    {
        $quiz = Quiz::find($id);
        $quiz->update($data);
        return $quiz;
    }

    public function deleteQuiz($data)
    {
        $quiz = Quiz::find($data);
        return $quiz->delete();
    }
}
