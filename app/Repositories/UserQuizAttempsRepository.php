<?php

namespace App\Repositories;

use App\Models\UserQuizAttemps;

class UserQuizAttempsRepository
{
    /**
     * Create a new quiz attempt record.
     */
    public function createAttempt($data)
    {
        return UserQuizAttemps::create($data);
    }

    /**
     * Get user's quiz attempts.
     */
    public function getUserAttempts($userId, $quizId = null)
    {
        $query = UserQuizAttemps::where('user_id', $userId);
        
        if ($quizId) {
            $query->where('quiz_id', $quizId);
        }
        
        return $query->with('quiz')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get a single attempt by ID.
     */
    public function getAttemptById($id)
    {
        return UserQuizAttemps::with(['quiz', 'user'])->find($id);
    }

    /**
     * Update an attempt.
     */
    public function updateAttempt($id, $data)
    {
        return UserQuizAttemps::find($id)->update($data);
    }

    /**
     * Check if user has passed a quiz.
     */
    public function hasUserPassedQuiz($userId, $quizId)
    {
        return UserQuizAttemps::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->where('passed', true)
            ->exists();
    }

    /**
     * Get best score for a user on a quiz.
     */
    public function getBestScore($userId, $quizId)
    {
        return UserQuizAttemps::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->max('score');
    }

    /**
     * Get attempts by quiz IDs for teacher analytics.
     */
    public function getAttemptsByQuizIds(array $quizIds)
    {
        if (empty($quizIds)) {
            return collect();
        }
        
        return UserQuizAttemps::whereIn('quiz_id', $quizIds)
            ->with(['user', 'quiz'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
