<?php

namespace App\Services;

use App\Repositories\UserQuizAttempsRepository;
use App\Repositories\QuizRepository;
use App\Repositories\UserRepository;
use App\Services\XpLogService;

class UserQuizAttempsService
{
    /**
     * Create a new class instance.
     */
    protected $attempsRepository;
    protected $quizRepository;
    protected $userRepository;
    protected $xpLogService;

    public function __construct(
        UserQuizAttempsRepository $attempsRepository,
        QuizRepository $quizRepository,
        UserRepository $userRepository,
        XpLogService $xpLogService
    ) {
        $this->attempsRepository = $attempsRepository;
        $this->quizRepository = $quizRepository;
        $this->userRepository = $userRepository;
        $this->xpLogService = $xpLogService;
    }

    /**
     * Submit a quiz attempt and calculate results.
     */
    public function submitQuizAttempt($userId, $quizId, $answers)
    {
        // Get quiz with questions
        $quiz = $this->quizRepository->getQuizById($quizId);
        
        if (!$quiz) {
            return null;
        }

        // Calculate score
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            
            if ($userAnswer && $userAnswer === $question->correct_answer) {
                $correctAnswers++;
            }
        }

        // Calculate percentage score
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        
        // Determine if passed
        $passed = $score >= $quiz->passing_score;
        
        // Calculate XP earned
        $xpEarned = 0;
        if ($passed) {
            $xpEarned = $quiz->xp_reward;
            
            // Award XP to user
            $user = $this->userRepository->getUserById($userId);
            $newXp = $user->xp + $xpEarned;
            $this->userRepository->updateUser($userId, ['xp' => $newXp]);
            
            // Log XP
            $this->xpLogService->logXp(
                $userId,
                $xpEarned,
                'quiz_completion',
                "Completed quiz: {$quiz->title}"
            );
        }

        // Create attempt record
        $attempt = $this->attempsRepository->createAttempt([
            'user_id' => $userId,
            'quiz_id' => $quizId,
            'score' => $score,
            'passed' => $passed,
            'xp_earned' => $xpEarned,
        ]);

        return $attempt;
    }

    /**
     * Get user's quiz attempts.
     */
    public function getUserQuizAttempts($userId, $quizId = null)
    {
        return $this->attempsRepository->getUserAttempts($userId, $quizId);
    }

    /**
     * Get quiz results for a specific attempt.
     */
    public function getQuizResults($attemptId)
    {
        return $this->attempsRepository->getAttemptById($attemptId);
    }

    /**
     * Check if user has passed a quiz.
     */
    public function checkIfUserPassedQuiz($userId, $quizId)
    {
        return $this->attempsRepository->hasUserPassedQuiz($userId, $quizId);
    }

    /**
     * Get user's best score for a quiz.
     */
    public function getBestScore($userId, $quizId)
    {
        return $this->attempsRepository->getBestScore($userId, $quizId);
    }
}
