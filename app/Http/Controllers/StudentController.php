<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    public function dashboard()
    {
        $data = [
            'title' => 'Student Dashboard',
        ];
        return view('student.dashboard', $data);
    }
    public function showCourses()
    {
        $data = [
            'title' => 'Courses',
            'courses' => $this->courseService->getAllCourse(),
        ];
        return view('student.courses', $data);
    }

    public function showCourseDetail($id)
    {
        $data = [
            'title' => 'Course Detail',
            'course' => $this->courseService->getCourseById($id),
        ];
        return view('student.course-detail', $data);
    }
}
