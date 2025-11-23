<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\UserProgressService;

class StudentController extends Controller
{
    protected $courseService;
    protected $userProgressService;
    public function __construct(CourseService $courseService, UserProgressService $userProgressService)
    {
        $this->courseService = $courseService;
        $this->userProgressService = $userProgressService;
    }
    public function dashboard()
    {
        $data = [
            'title' => 'Student Dashboard',
            'coursesTaken' => $this->userProgressService->getCoursesTaken(Auth::user()->id),
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

    public function studentTakeACourse($id)
    {
        $this->userProgressService->takeACourse(auth()->user()->id, $id);
        return redirect()->route('student.courses.learning-preview', $id)->with('success', 'You have successfully taken the course.');
    }

    public function showLearningPreview($id)
    {
        $data = [
            'title' => 'Learning Preview',
            'course' => $this->courseService->getCourseById($id),
        ];
        return view('student.learning-preview', $data);
    }
}
