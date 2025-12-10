<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\MaterialService;
use App\Services\UserProgressService;
use App\Services\UserQuizAttempsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    protected $courseService;
    protected $materialService;
    protected $userProgressService;
    protected $quizAttempsService;

    public function __construct(
        CourseService $courseService,
        MaterialService $materialService,
        UserProgressService $userProgressService,
        UserQuizAttempsService $quizAttempsService
    ) {
        $this->courseService = $courseService;
        $this->materialService = $materialService;
        $this->userProgressService = $userProgressService;
        $this->quizAttempsService = $quizAttempsService;
    }

    public function view($materialId)
    {
        $material = $this->materialService->getMaterialById($materialId);
        $course = $material->course;
        $userId = Auth::id();
        
        // Parse markdown content to HTML
        $material->content = \App\Helpers\MarkdownHelper::parse($material->content);
        
        // Convert YouTube URL to embed format
        if ($material->video_url) {
            $material->video_url = \App\Helpers\MarkdownHelper::convertYouTubeUrl($material->video_url);
        }
        
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

    public function complete(Request $request, $materialId)
    {
        $user = Auth::user();
        $material = $this->materialService->getMaterialById($materialId);
        $course = $material->course;
        
        // Award XP for completing the material
        $user->addXP($material->xp_reward);
        
        // Check if we should redirect to next material or back to course
        if ($request->has('next_material_id')) {
            return redirect()->route('student.material.view', $request->next_material_id)
                ->with('success', 'Material completed! +' . $material->xp_reward . ' XP earned!');
        }
        
        // Return to course page
        return redirect()->route('student.courses.learn', $course->id)
            ->with('success', 'Material completed! +' . $material->xp_reward . ' XP earned!');
    }
}
