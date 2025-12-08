<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllQuestions()
    {
        return Question::all();
    }

    public function getQuestionById($id)
    {
        return Question::find($id);
    }

    public function createQuestion($data)
    {
        return Question::create($data);
    }


    public function updateQuestion($id, $data)
    {
        return Question::find($id)->update($data);
    }


    public function deleteQuestion($id)
    {
        return Question::find($id)->delete();
    }
}
