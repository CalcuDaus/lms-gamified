<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index()
    {
        $teacher = Auth::user();
        $courses = $this->courseService->getCoursesByTeacher($teacher->id);
        
        $data = [
            'title' => 'My Courses',
            'courses' => $courses,
        ];
        return view('teacher.courses.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Course',
        ];
        return view('teacher.courses.create', $data);
    }

    public function store(CourseRequest $request)
    {
        if ($this->courseService->createCourse($request->validated())) {
            return redirect()->route('teacher.courses.index')->with('success', 'Course created successfully!');
        }
        return redirect()->back()->with('error', 'Failed to create course.');
    }

    public function edit($id)
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

    public function update(CourseRequest $request, $id)
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

    public function destroy($id)
    {
        $course = $this->courseService->getCourseById($id);
        
        // Authorization check
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to delete this course.');
        }
        
        $this->courseService->deleteCourse($id);
        return redirect()->route('teacher.courses.index')->with('success', 'Course deleted successfully!');
    }
}
