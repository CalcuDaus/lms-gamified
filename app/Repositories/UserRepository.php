<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getUserById($id)
    {
        return User::find($id);
    }
    public function getAllUsers()
    {
        return User::all();
    }
    public function createUser($data)
    {
        return User::create($data);
    }
    public function updateUser($id, $data)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        return $user->delete();
    }
}
