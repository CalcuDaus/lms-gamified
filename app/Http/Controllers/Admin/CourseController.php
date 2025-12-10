<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Http\Requests\CourseRequest;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index()
    {
        $data = [
            'title' => 'Courses',
            'courses' => $this->courseService->getAllCourse(),
        ];
        return view('admin.courses.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Course',
        ];
        return view('admin.courses.create', $data);
    }

    public function store(CourseRequest $request)
    {
        if ($this->courseService->createCourse($request->validated())) {
            return redirect()->route('courses.index')->with('success', 'Course created successfully');
        }
        return redirect()->back()->with('error', 'Course could not be created!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Course',
            'course' => $this->courseService->getCourseById($id)
        ];
        return view('admin.courses.edit', $data);
    }

    public function update(CourseRequest $request, string $id)
    {
        if ($this->courseService->updateCourse($id, $request->validated())) {
            return redirect()->route('courses.index')->with('success', 'Course updated successfully');
        }
        return redirect()->back()->with('error', 'Course could not be updated!');
    }

    public function destroy(string $id)
    {
        $this->courseService->deleteCourse($id);
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }
}
