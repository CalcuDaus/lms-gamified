<?php

namespace App\Repositories;

use App\Models\Material;

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
    public function getAllMaterials()
    {
        return Material::all();
    }

    /**
     * Get a material by ID.
     */
    public function getMaterialById($id)
    {
        return Material::find($id);
    }

    public function createMaterial($data)
    {
        return Material::create($data);
    }
    public function updateMaterial($id, $data)
    {
        $material = Material::find($id);
        $material->update($data);
        return $material;
    }

    public function deleteMaterial($data)
    {
        $material = Material::find($data);
        return $material->delete();
    }
}
