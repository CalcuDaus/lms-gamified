<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * Create a new class instance.
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function createUser($data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        if (request()->hasFile('avatar')) {
            $data['avatar'] = request()->file('avatar')->store('avatars', 'public');
        }
        return $this->userRepository->createUser($data);
    }
    public function updateUser($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (request()->hasFile('avatar')) {
            $data['avatar'] = request()->file('avatar')->store('avatars', 'public');
        } else {
            $user = $this->userRepository->getUserById($id);
            $data['avatar'] = $user->avatar;
        }
        return $this->userRepository->updateUser($id, $data);
    }
    public function deleteUser($id)
    {
        $user = $this->userRepository->getUserById($id);
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        return $this->userRepository->deleteUser($id);
    }
}
