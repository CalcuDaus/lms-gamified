<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\UserProgressService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $courseService;
    protected $userProgressService;
    protected $userRepository;

    public function __construct(
        CourseService $courseService,
        UserProgressService $userProgressService,
        UserRepository $userRepository
    ) {
        $this->courseService = $courseService;
        $this->userProgressService = $userProgressService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $user->updateStreak();
        
        $enrolledCourses = \App\Models\UserProgress::where('user_id', $user->id)
            ->with(['course.material.quizzes'])
            ->paginate(4)
            ->through(function ($progress) use ($user) {
                $course = $progress->course;
                $totalQuizzes = $course->material->sum(fn($m) => $m->quizzes->count());
                $course->completion_percentage = 0;
                if ($totalQuizzes > 0) {
                    $completed = \App\Models\UserQuizAttemps::where('user_id', $user->id)
                        ->where('passed', true)
                        ->whereIn('quiz_id', $course->material->flatMap->quizzes->pluck('id'))
                        ->distinct('quiz_id')->count();
                    $course->completion_percentage = round(($completed / $totalQuizzes) * 100);
                }
                return $course;
            });

        $totalCompletedQuizzes = \App\Models\UserQuizAttemps::where('user_id', $user->id)
            ->where('passed', true)->distinct('quiz_id')->count();

        return view('student.dashboard', [
            'title' => 'Dashboard',
            'enrolledCourses' => $enrolledCourses,
            'totalCompletedQuizzes' => $totalCompletedQuizzes,
        ]);
    }
}
