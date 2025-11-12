<?php

namespace App\Services;

use App\Repositories\MaterialRepository;

class MaterialService
{
    /**
     * Create a new class instance.
     */
    protected $materialRepository;
    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function getAllMaterials()
    {
        return $this->materialRepository->getAllMaterials();
    }

    public function getMaterialById($id)
    {
        return $this->materialRepository->getMaterialById($id);
    }

    public function createMaterial($data)
    {
        return $this->materialRepository->createMaterial($data);
    }

    public function updateMaterial($id, $data)
    {
        return $this->materialRepository->updateMaterial($id, $data);
    }

    public function deleteMaterial($id)
    {
        return $this->materialRepository->deleteMaterial($id);
    }
}
