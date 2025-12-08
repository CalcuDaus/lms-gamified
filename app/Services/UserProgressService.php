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

    public function getStudentCountByTeacher($teacherId)
    {
        return $this->userProgressRepository->getStudentCountByTeacher($teacherId);
    }

    public function getStudentsByCourse($courseId)
    {
        return $this->userProgressRepository->getStudentsByCourse($courseId);
    }

    public function getStudentProgressInTeacherCourses($userId, $teacherId)
    {
        return $this->userProgressRepository->getStudentProgressInTeacherCourses($userId, $teacherId);
    }
}
