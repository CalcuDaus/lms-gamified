<?php

namespace App\Repositories;

use App\Models\Quiz;

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
        return Quiz::find($id)->pdate($data);
    }

    public function deleteQuiz($data)
    {
        return Quiz::find($data)->delete();
    }
}
