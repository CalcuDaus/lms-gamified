<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\MaterialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    protected $courseService;
    protected $materialService;

    public function __construct(
        CourseService $courseService,
        MaterialService $materialService
    ) {
        $this->courseService = $courseService;
        $this->materialService = $materialService;
    }

    public function create($courseId)
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

    public function store(Request $request, $courseId)
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

    public function edit($id)
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

    public function update(Request $request, $id)
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

    public function destroy($id)
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
}
