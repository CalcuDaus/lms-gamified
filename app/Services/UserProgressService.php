<?php

namespace App\Services;

use App\Models\UserProgress;
use App\Repositories\UserProgressRepository;
use Illuminate\Database\Eloquent\Collection;

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

    public function getCoursesTaken($id): int
    {
        return $this->userProgressRepository->getCoursesTaken($id);
    }
    public function takeACourse($userId, $courseId): UserProgress
    {
        return $this->userProgressRepository->takeACourse($userId, $courseId);
    }

    public function getStudentCountByTeacher($teacherId): int
    {
        return $this->userProgressRepository->getStudentCountByTeacher($teacherId);
    }

    public function getStudentsByCourse($courseId): Collection
    {
        return $this->userProgressRepository->getStudentsByCourse($courseId);
    }

    public function getStudentProgressInTeacherCourses($userId, $teacherId): Collection
    {
        return $this->userProgressRepository->getStudentProgressInTeacherCourses($userId, $teacherId);
    }
}
