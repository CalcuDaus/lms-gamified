<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\MaterialService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $materialService;
    protected $courseService;

    public function __construct(MaterialService $materialService, CourseService $courseService)
    {
        $this->materialService = $materialService;
        $this->courseService = $courseService;
    }
    public function index()
    {
        $data = [
            'title' => 'Material Management',
            'materials' => $this->materialService->getAllMaterials(),
        ];
        return view('admin.materials.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Create Material',
            'courses' => $this->courseService->getAllCourse(),
        ];
        return view('admin.materials.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        $this->materialService->createMaterial($request->validated());
        return redirect()->route('materials.index')->with('success', 'Material created successfully.');
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
            'title' => 'Edit Material',
            'material' => $this->materialService->getMaterialById($id),
            'courses' => $this->courseService->getAllCourse(),
        ];

        return view('admin.materials.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialRequest $request, string $id)
    {
        $this->materialService->updateMaterial($id, $request->validated());
        return redirect()->route('materials.index')->with('success', 'Material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->materialService->deleteMaterial($id);
        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}
