<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = [
            'title' => 'User Management',
            'users' => User::all()
        ];
        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'User Create',
        ];
        return view('admin.users.create', $data);
    }

    public function store(UserRequest $request)
    {
        $this->userService->createUser($request->validated());
        return redirect()->route(' users.index')->with('success', 'User created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'User Edit',
            'user' => $this->userService->getUserById($id)
        ];
        return view('admin.users.edit', $data);
    }

    public function update(UserRequest $request, string $id)
    {
        $this->userService->updateUser($id, $request->validated());
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
