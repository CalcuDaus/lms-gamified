<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAllCourses(): Collection
    {
        return Course::all();
    }
    public function getCourseById($id): ?Course
    {
        return Course::find($id);
    }

    public function getPaginatedCourses(int $perPage = 6)
    {
        return Course::paginate($perPage);
    }

    public function getCoursesByTeacher($teacherId): Collection
    {
        return Course::where('created_by', $teacherId)->get();
    }
    public function createCourse($data): Course
    {
        return Course::create($data);
    }
    public function updateCourse($id, $data): bool
    {
        return Course::find($id)->update($data);
    }
    public function deleteCourse($id): ?bool
    {
        return Course::find($id)->delete();
    }
}
