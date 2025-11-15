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

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
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
        return User::find($id)->update($data);
    }
    public function deleteUser($id)
    {
        return User::find($id)->delete();
    }
}
