<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\QuizService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\UserProgressService;
use App\Services\UserQuizAttempsService;
use App\Repositories\UserRepository;

class StudentController extends Controller
{
    protected $courseService;
    protected $userProgressService;
    protected $quizAttempsService;
    protected $quizService;
    protected $userRepository;

    public function __construct(
        CourseService $courseService, 
        UserProgressService $userProgressService,
        UserQuizAttempsService $quizAttempsService,
        QuizService $quizService,
        UserRepository $userRepository
    ) {
        $this->courseService = $courseService;
        $this->userProgressService = $userProgressService;
        $this->quizAttempsService = $quizAttempsService;
        $this->quizService = $quizService;
        $this->userRepository = $userRepository;
    }
    public function dashboard()
    {
        $user = Auth::user();
        $user->updateStreak();
        
        $enrolledCourses = \App\Models\UserProgress::where('user_id', $user->id)
            ->with(['course.material.quizzes'])
            ->get()->map(function ($progress) use ($user) {
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

    public function startQuiz($quizId)
    {
        $quiz = $this->quizService->getQuizById($quizId);
        $data = [
            'title' => 'Take Quiz: ' . $quiz->title,
            'quiz' => $quiz,
        ];
        return view('student.start-quiz', $data);
    }

    public function submitQuiz(Request $request, $quizId)
    {
        $userId = Auth::id();
        $answers = $request->input('answers', []);
        
        $attempt = $this->quizAttempsService->submitQuizAttempt($userId, $quizId, $answers);
        
        return redirect()->route('student.quiz.results', $attempt->id)->with('success', 'Quiz submitted successfully!');
    }

    public function showQuizResults($attemptId)
    {
        $attempt = $this->quizAttempsService->getQuizResults($attemptId);
        $data = [
            'title' => 'Quiz Results',
            'attempt' => $attempt,
        ];
        return view('student.quiz-results', $data);
    }

    public function leaderboard()
    {
        $topUsers = $this->userRepository->getAllUsers()->sortByDesc('xp')->take(10);
        $data = [
            'title' => 'Leaderboard',
            'topUsers' => $topUsers,
            'currentUser' => Auth::user(),
        ];
        return view('student.leaderboard', $data);
    }

    public function learn($courseId)
    {
        $course = $this->courseService->getCourseById($courseId);
        $userId = Auth::id();
        
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
            'userAttempts' => $userAttempts,
        ];
        return view('student.learn', $data);
    }

    public function viewMaterial($materialId)
    {
        $materialService = app(\App\Services\MaterialService::class);
        $material = $materialService->getMaterialById($materialId);
        $course = $material->course;
        $userId = Auth::id();
        
        // Get all materials in this course for navigation
        $allMaterials = $course->material;
        $materialIndex = $allMaterials->search(function($item) use ($materialId) {
            return $item->id == $materialId;
        });
        
        // Find previous and next materials
        $previousMaterial = $materialIndex > 0 ? $allMaterials[$materialIndex - 1] : null;
        $nextMaterial = $materialIndex < $allMaterials->count() - 1 ? $allMaterials[$materialIndex + 1] : null;
        
        // Calculate progress
        $progress = (($materialIndex + 1) / $allMaterials->count()) * 100;
        
        // Get user's quiz attempts for this material
        $quizIds = $material->quizzes->pluck('id');
        $userAttempts = collect();
        foreach ($quizIds as $quizId) {
            $attempts = $this->quizAttempsService->getUserQuizAttempts($userId, $quizId);
            $userAttempts = $userAttempts->merge($attempts);
        }
        
        $gradients = [
            ['from' => 'from-red-500', 'to' => 'to-pink-500'],
            ['from' => 'from-blue-500', 'to' => 'to-cyan-500'],
            ['from' => 'from-green-500', 'to' => 'to-emerald-500'],
            ['from' => 'from-purple-500', 'to' => 'to-pink-500'],
            ['from' => 'from-orange-500', 'to' => 'to-yellow-500'],
            ['from' => 'from-indigo-500', 'to' => 'to-purple-500'],
        ];
        
        $data = [
            'title' => $material->title,
            'material' => $material,
            'course' => $course,
            'userAttempts' => $userAttempts,
            'materialIndex' => $materialIndex,
            'totalMaterials' => $allMaterials->count(),
            'previousMaterial' => $previousMaterial,
            'nextMaterial' => $nextMaterial,
            'progress' => round($progress),
            'gradients' => $gradients,
        ];
        
        return view('student.material-view', $data);
    }
}
