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
        return Material::find($id)->update($data);
    }

    public function deleteMaterial($data)
    {
        return Material::find($data)->delete();
    }
}
