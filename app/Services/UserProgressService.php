<?php

namespace App\Services;

use App\Repositories\UserProgressRepository;

class UserProgressService
{
    /**
     * Create a new class instance.
     */
    protected $userProgressRepository;
    public function __construct(UserProgressRepository $userProgressRepository)
    {
        $this->userProgressRepository = $userProgressRepository;
    }

    public function getCoursesTaken($id)
    {
        return $this->userProgressRepository->getCoursesTaken($id);
    }
    public function takeACourse($userId, $courseId)
    {
        return $this->userProgressRepository->takeACourse($userId, $courseId);
    }
}
