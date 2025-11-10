<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Create Course',
        ];
        return view('admin.courses.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        if ($this->courseService->createCourse($request->validated())) {
            return redirect()->route('courses.index')->with('success', 'Course created successfully');
        }
        return redirect()->back()->with('error', 'Course could not be created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Course',
            'course' => $this->courseService->getCourseById($id)
        ];
        return view('admin.courses.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, string $id)
    {
        if ($this->courseService->updateCourse($id, $request->validated())) {
            return redirect()->route('courses.index')->with('success', 'Course updated successfully');
        }
        return redirect()->back()->with('error', 'Course could not be updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->courseService->deleteCourse($id);
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }
}
