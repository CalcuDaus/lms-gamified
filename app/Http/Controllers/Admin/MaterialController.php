<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\MaterialService;
use App\Http\Requests\MaterialRequest;

class MaterialController extends Controller
{
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

    public function create()
    {
        $data = [
            'title' => 'Create Material',
            'courses' => $this->courseService->getAllCourse(),
        ];
        return view('admin.materials.create', $data);
    }

    public function store(MaterialRequest $request)
    {
        $this->materialService->createMaterial($request->validated());
        return redirect()->route('materials.index')->with('success', 'Material created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Material',
            'material' => $this->materialService->getMaterialById($id),
            'courses' => $this->courseService->getAllCourse(),
        ];

        return view('admin.materials.edit', $data);
    }

    public function update(MaterialRequest $request, string $id)
    {
        $this->materialService->updateMaterial($id, $request->validated());
        return redirect()->route('materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->materialService->deleteMaterial($id);
        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}
