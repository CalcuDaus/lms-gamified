<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAllCourses()
    {
        return Course::all();
    }
    public function getCourseById($id)
    {
        return Course::find($id);
    }
    public function createCourse($data)
    {
        return Course::create($data);
    }
    public function updateCourse($id, $data)
    {
        $course = Course::find($id);
        $course->update($data);
        return $course;
    }
    public function deleteCourse($id)
    {
        $course = Course::find($id);
        return $course->delete();
    }
}
