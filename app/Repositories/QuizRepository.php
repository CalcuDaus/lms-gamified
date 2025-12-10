<?php

namespace App\Repositories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

class QuizRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllQuizzes(): Collection
    {
        return Quiz::all();
    }

    public function getQuizById($id): ?Quiz
    {
        return Quiz::find($id);
    }
    public function createQuiz($data): Quiz
    {
        return Quiz::create($data);
    }

    public function updateQuiz($id, $data): bool
    {
        return Quiz::find($id)->update($data);
    }

    public function deleteQuiz($data): ?bool
    {
        return Quiz::find($data)->delete();
    }
}
