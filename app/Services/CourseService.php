<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class CourseService
{
    /**
     * Create a new class instance.
     */
    protected $courseRepository;
    protected $imageService;

    public function __construct(CourseRepository $courseRepository, ImageService $imageService)
    {
        $this->courseRepository = $courseRepository;
        $this->imageService = $imageService;
    }
    public function getAllCourse(): Collection
    {
        return $this->courseRepository->getAllCourses();
    }

    public function getPaginatedCourses(int $perPage = 6)
    {
        return $this->courseRepository->getPaginatedCourses($perPage);
    }

    public function getCourseById($id): ?Course
    {
        return $this->courseRepository->getCourseById($id);
    }

    public function getCoursesByTeacher($teacherId): Collection
    {
        return $this->courseRepository->getCoursesByTeacher($teacherId);
    }

    public function createCourse($data): Course
    {
        $data['created_by'] = auth()->user()->id;

        if (request()->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->imageService->convertAndStore(request()->file('thumbnail'), 'thumbnails');
        }
        return $this->courseRepository->createCourse($data);
    }

    public function updateCourse($id, $data): bool
    {
        $course = $this->courseRepository->getCourseById($id);
        
        if (request()->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail) {
                $this->imageService->delete($course->thumbnail);
            }
            $data['thumbnail'] = $this->imageService->convertAndStore(request()->file('thumbnail'), 'thumbnails');
        } else {
            $data['thumbnail'] = $course->thumbnail;
        }

        return $this->courseRepository->updateCourse($id, $data);
    }

    public function deleteCourse($id): ?bool
    {
        $course = $this->courseRepository->getcourseById($id);
        if ($course->thumbnail) {
            $this->imageService->delete($course->thumbnail);
        }
        return $this->courseRepository->deleteCourse($id);
    }
}
