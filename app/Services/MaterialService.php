<?php

namespace App\Services;

use App\Models\Material;
use App\Repositories\MaterialRepository;
use Illuminate\Database\Eloquent\Collection;

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

    public function getAllMaterials(): Collection
    {
        return $this->materialRepository->getAllMaterials();
    }

    public function getMaterialById($id): ?Material
    {
        return $this->materialRepository->getMaterialById($id);
    }

    public function createMaterial($data): Material
    {
        return $this->materialRepository->createMaterial($data);
    }

    public function updateMaterial($id, $data): bool
    {
        return $this->materialRepository->updateMaterial($id, $data);
    }

    public function deleteMaterial($id): ?bool
    {
        return $this->materialRepository->deleteMaterial($id);
    }
}
