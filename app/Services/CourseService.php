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

        if (request()->hasFile('thumbnail')) {
            $data['thumbnail'] = request()->file('thumbnail')->store('thumbnails', 'public');
        }
        return $this->courseRepository->createCourse($data);
    }

    public function updateCourse($id, $data)
    {

        if (request()->hasFile('thumbnail')) {
            $data['thumbnail'] = request()->file('thumbnail')->store('thumbnails', 'public');
        } else {
            $course = $this->courseRepository->getCourseById($id);
            $data['thumbnail'] = $course->thumbnail;
        }

        return $this->courseRepository->updateCourse($id, $data);
    }

    public function deleteCourse($id)
    {
        $course = $this->courseRepository->getcourseById($id);
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        return $this->courseRepository->deleteCourse($id);
    }
}
