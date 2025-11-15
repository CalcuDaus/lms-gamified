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
        Question::all();
    }

    public function getQuestionById($id)
    {
        Question::find($id);
    }

    public function createQuestion($data)
    {
        Question::create($data);
    }


    public function updateQuestion($id, $data)
    {
        Question::find($id)->update($data);
    }


    public function deleteQuestion($id)
    {
        Question::find($id)->delete();
    }
}
