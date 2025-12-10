<?php

namespace App\Repositories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Collection;

class MaterialRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get all materials.
     */
    public function getAllMaterials(): Collection
    {
        return Material::all();
    }

    /**
     * Get a material by ID.
     */
    public function getMaterialById($id): ?Material
    {
        return Material::find($id);
    }

    public function createMaterial($data): Material
    {
        return Material::create($data);
    }
    public function updateMaterial($id, $data): bool
    {
        return Material::find($id)->update($data);
    }

    public function deleteMaterial($data): ?bool
    {
        return Material::find($data)->delete();
    }
}
