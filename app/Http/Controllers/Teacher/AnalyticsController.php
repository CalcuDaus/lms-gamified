<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\UserProgressService;
use App\Services\UserQuizAttempsService;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
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

    public function courseAnalytics($courseId)
    {
        $course = $this->courseService->getCourseById($courseId);
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        // Get all students enrolled in this course
        $enrolledStudents = $this->userProgressService->getStudentsByCourse($courseId);
        
        // Get quiz attempts for this course
        $quizIds = $course->material->flatMap(function($material) {
            return $material->quizzes->pluck('id');
        });
        
        $attempts = $this->quizAttempsService->getAttemptsByQuizIds($quizIds->toArray());
        
        $data = [
            'title' => 'Course Analytics - ' . $course->title,
            'course' => $course,
            'enrolledStudents' => $enrolledStudents,
            'totalAttempts' => $attempts, // Pass the collection, not the count
            'averageScore' => $attempts->avg('score') ?? 0,
        ];
        return view('teacher.analytics.course', $data);
    }

    public function studentProgress($userId, $courseId = null)
    {
        $student = \App\Models\User::findOrFail($userId);
        $teacher = Auth::user();
        
        // Get courses created by this teacher
        $teacherCourses = $this->courseService->getCoursesByTeacher($teacher->id);
        
        // Get student's progress in teacher's courses
        $studentProgress = $this->userProgressService->getStudentProgressInTeacherCourses($userId, $teacher->id);
        
        $data = [
            'title' => 'Student Progress - ' . $student->name,
            'student' => $student,
            'progress' => $studentProgress,
        ];
        return view('teacher.analytics.student', $data);
    }
}
