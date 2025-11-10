<?php

namespace App\Services;

use App\Repositories\CourseRepository;

class CourseService
{
    /**
     * Create a new class instance.
     */
    protected $courseRepository;
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    public function getAllCourse()
    {
        return $this->courseRepository->getAllCourses();
    }

    public function getCourseById($id)
    {
        return $this->courseRepository->getCourseById($id);
    }

    public function createCourse($data)
    {
        $data['created_by'] = auth()->user()->id;
        return $this->courseRepository->createCourse($data);
    }

    public function updateCourse($id, $data)
    {
        return $this->courseRepository->updateCourse($id, $data);
    }

    public function deleteCourse($id)
    {
        return $this->courseRepository->deleteCourse($id);
    }
}
