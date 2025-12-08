<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\MaterialService;
use App\Services\QuizService;
use App\Services\UserQuizAttempsService;
use App\Services\UserProgressService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CourseRequest;
use App\Models\Question;

class TeacherController extends Controller
{
    protected $courseService;
    protected $materialService;
    protected $quizService;
    protected $quizAttempsService;
    protected $userProgressService;

    public function __construct(
        CourseService $courseService,
        MaterialService $materialService,
        QuizService $quizService,
        UserQuizAttempsService $quizAttempsService,
        UserProgressService $userProgressService
    ) {
        $this->courseService = $courseService;
        $this->materialService = $materialService;
        $this->quizService = $quizService;
        $this->quizAttempsService = $quizAttempsService;
        $this->userProgressService = $userProgressService;
    }

    // Dashboard
    public function dashboard()
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

    // ===== COURSE MANAGEMENT =====
    
    public function indexCourses()
    {
        $teacher = Auth::user();
        $courses = $this->courseService->getCoursesByTeacher($teacher->id);
        
        $data = [
            'title' => 'My Courses',
            'courses' => $courses,
        ];
        return view('teacher.courses.index', $data);
    }

    public function createCourse()
    {
        $data = [
            'title' => 'Create New Course',
        ];
        return view('teacher.courses.create', $data);
    }

    public function storeCourse(CourseRequest $request)
    {
        if ($this->courseService->createCourse($request->validated())) {
            return redirect()->route('teacher.courses.index')->with('success', 'Course created successfully!');
        }
        return redirect()->back()->with('error', 'Failed to create course.');
    }

    public function editCourse($id)
    {
        $course = $this->courseService->getCourseById($id);
        
        // Authorization check - ensure teacher owns this course
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to edit this course.');
        }
        
        $data = [
            'title' => 'Edit Course',
            'course' => $course,
        ];
        return view('teacher.courses.edit', $data);
    }

    public function updateCourse(CourseRequest $request, $id)
    {
        $course = $this->courseService->getCourseById($id);
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to update this course.');
        }
        
        if ($this->courseService->updateCourse($id, $request->validated())) {
            return redirect()->route('teacher.courses.index')->with('success', 'Course updated successfully!');
        }
        return redirect()->back()->with('error', 'Failed to update course.');
    }

    public function destroyCourse($id)
    {
        $course = $this->courseService->getCourseById($id);
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to delete this course.');
        }
        
        $this->courseService->deleteCourse($id);
        return redirect()->route('teacher.courses.index')->with('success', 'Course deleted successfully!');
    }

    // ===== MATERIAL MANAGEMENT =====

    public function createMaterial($courseId)
    {
        
        $course = $this->courseService->getCourseById($courseId);
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to add materials to this course.');
        }
        
        $data = [
            'title' => 'Add Material',
            'course' => $course,
        ];
        return view('teacher.materials.create', $data);
    }

    public function storeMaterial(Request $request, $courseId)
    {
        $course = $this->courseService->getCourseById($courseId);
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'file' => 'nullable|file|max:10240', // 10MB max
            'xp_reward' => 'required|integer|min:0',
        ]);
        
        $validated['course_id'] = $courseId;
        
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('materials', 'public');
        }
        
        $this->materialService->createMaterial($validated);
        return redirect()->route('teacher.courses.index')->with('success', 'Material added successfully!');
    }

    public function editMaterial($id)
    {
        $material = $this->materialService->getMaterialById($id);
        $course = $material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $data = [
            'title' => 'Edit Material',
            'material' => $material,
            'course' => $course,
        ];
        return view('teacher.materials.edit', $data);
    }

    public function updateMaterial(Request $request, $id)
    {
        $material = $this->materialService->getMaterialById($id);
        $course = $material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'file' => 'nullable|file|max:10240',
            'xp_reward' => 'required|integer|min:0',
        ]);
        
        // Keep existing file if no new file uploaded
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('materials', 'public');
        } else {
            $validated['file'] = $material->file;
        }
        
        // Keep existing video_url if empty
        if (empty($validated['video_url']) && !empty($material->video_url)) {
            $validated['video_url'] = $material->video_url;
        }
        
        $this->materialService->updateMaterial($id, $validated);
        return redirect()->route('teacher.courses.index')->with('success', 'Material updated successfully!');
    }

    public function destroyMaterial($id)
    {
        $material = $this->materialService->getMaterialById($id);
        $course = $material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $this->materialService->deleteMaterial($id);
        return redirect()->back()->with('success', 'Material deleted successfully!');
    }

    // ===== QUIZ MANAGEMENT =====

    public function createQuiz($materialId)
    {
        $material = $this->materialService->getMaterialById($materialId);
        $course = $material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $data = [
            'title' => 'Create Quiz',
            'material' => $material,
        ];
        return view('teacher.quizzes.create', $data);
    }

    public function storeQuiz(Request $request, $materialId)
    {
        $material = $this->materialService->getMaterialById($materialId);
        $course = $material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'xp_reward' => 'required|integer|min:0',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);
        
        $validated['material_id'] = $materialId;
        
        $quiz = $this->quizService->createQuiz($validated);
        return redirect()->route('teacher.questions.manage', $quiz->id)->with('success', 'Quiz created! Now add questions.');
    }

    public function editQuiz($id)
    {
        $quiz = $this->quizService->getQuizById($id);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $data = [
            'title' => 'Edit Quiz',
            'quiz' => $quiz,
        ];
        return view('teacher.quizzes.edit', $data);
    }

    public function updateQuiz(Request $request, $id)
    {
        $quiz = $this->quizService->getQuizById($id);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'xp_reward' => 'required|integer|min:0',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);
        
        $this->quizService->updateQuiz($id, $validated);
        return redirect()->route('teacher.courses.index')->with('success', 'Quiz updated successfully!');
    }

    public function destroyQuiz($id)
    {
        $quiz = $this->quizService->getQuizById($id);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $this->quizService->deleteQuiz($id);
        return redirect()->back()->with('success', 'Quiz deleted successfully!');
    }

    // ===== QUESTION MANAGEMENT =====

    public function manageQuestions($quizId)
    {
        $quiz = $this->quizService->getQuizById($quizId);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $data = [
            'title' => 'Manage Questions - ' . $quiz->title,
            'quiz' => $quiz,
        ];
        return view('teacher.questions.manage', $data);
    }

    public function storeQuestion(Request $request, $quizId)
    {
        $quiz = $this->quizService->getQuizById($quizId);
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string',
        ]);
        
        $validated['quiz_id'] = $quizId;
        
        Question::create($validated);
        return redirect()->back()->with('success', 'Question added successfully!');
    }

    public function editQuestion($id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $data = [
            'title' => 'Edit Question',
            'question' => $question,
            'quiz' => $quiz,
        ];
        return view('teacher.questions.edit', $data);
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string',
        ]);
        
        $question->update($validated);
        return redirect()->route('teacher.questions.manage', $quiz->id)->with('success', 'Question updated successfully!');
    }

    public function destroyQuestion($id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        $course = $quiz->material->course;
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }
        
        $quizId = $quiz->id;
        $question->delete();
        return redirect()->route('teacher.questions.manage', $quizId)->with('success', 'Question deleted successfully!');
    }

    // ===== STUDENT MONITORING =====

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
