<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\UserProgressService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $courseService;
    protected $userProgressService;

    public function __construct(
        CourseService $courseService,
        UserProgressService $userProgressService
    ) {
        $this->courseService = $courseService;
        $this->userProgressService = $userProgressService;
    }

    public function index()
    {
        $teacher = Auth::user();
        $courses = $this->courseService->getCoursesByTeacher($teacher->id);
        
        // Calculate total enrolled students across all courses
        $totalStudents = $this->userProgressService->getStudentCountByTeacher($teacher->id);
        
        $data = [
            'title' => 'Teacher Dashboard',
            'courses' => $courses,
            'totalStudents' => $totalStudents,
        ];
        return view('teacher.dashboard', $data);
    }
}
