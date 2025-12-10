<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\UserProgressService;
use App\Services\UserQuizAttempsService;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    protected $courseService;
    protected $userProgressService;
    protected $quizAttempsService;

    public function __construct(
        CourseService $courseService,
        UserProgressService $userProgressService,
        UserQuizAttempsService $quizAttempsService
    ) {
        $this->courseService = $courseService;
        $this->userProgressService = $userProgressService;
        $this->quizAttempsService = $quizAttempsService;
    }

    public function index()
    {
        // Responsive pagination: 4 on desktop, 3 on mobile
        $userAgent = request()->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent);
        $perPage = request()->get('per_page', $isMobile ? 3 : 4);
        
        $data = [
            'title' => 'Courses',
            'courses' => $this->courseService->getPaginatedCourses((int) $perPage),
        ];
        return view('student.courses', $data);
    }

    public function show($id)
    {
        $data = [
            'title' => 'Course Detail',
            'course' => $this->courseService->getCourseById($id),
        ];
        return view('student.course-detail', $data);
    }

    public function take($id)
    {
        $this->userProgressService->takeACourse(auth()->user()->id, $id);
        return redirect()->route('student.courses.learning-preview', $id)->with('success', 'You have successfully taken the course.');
    }

    public function learningPreview($id)
    {
        $data = [
            'title' => 'Learning Preview',
            'course' => $this->courseService->getCourseById($id),
        ];
        return view('student.learning-preview', $data);
    }

    public function learn($courseId)
    {
        $course = $this->courseService->getCourseById($courseId);
        $userId = Auth::id();
        
        // Paginate materials - 3 per page
        $materials = \App\Models\Material::where('course_id', $courseId)
            ->with('quizzes')
            ->orderBy('id')
            ->paginate(3);
        
        // Get all user's quiz attempts for this course to track progress
        $quizIds = $course->material->flatMap(function($material) {
            return $material->quizzes->pluck('id');
        });
        
        $userAttempts = collect();
        foreach ($quizIds as $quizId) {
            $attempts = $this->quizAttempsService->getUserQuizAttempts($userId, $quizId);
            $userAttempts = $userAttempts->merge($attempts);
        }
        
        $data = [
            'title' => 'Learning: ' . $course->title,
            'course' => $course,
            'materials' => $materials,
            'userAttempts' => $userAttempts,
        ];
        return view('student.learn', $data);
    }
}
