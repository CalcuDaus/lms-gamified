@extends('layouts.app')

@section('content')
    <div class="max-w-[600px] mx-auto mt-10 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-custom font-balo">
        <h2 class="text-2xl font-semibold mb-6 text-center dark:text-gray-100">Edit User</h2>

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            {{-- Name --}}
            <div>
                <label for="name" class="block mb-1 font-medium dark:text-gray-200">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block mb-1 font-medium dark:text-gray-200">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block mb-1 font-medium dark:text-gray-200">Password (leave blank to keep
                    current)</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block mb-1 font-medium dark:text-gray-200">Role</label>
                <select id="role" name="role"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="block mb-1 font-medium dark:text-gray-200">Phone</label>
                <input type="text" id="phone" name="phone"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Level --}}
            <div>
                <label for="level" class="block mb-1 font-medium dark:text-gray-200">Level</label>
                <input type="number" id="level" name="level"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('level', $user->level) }}" min="1">
            </div>

            {{-- XP --}}
            <div>
                <label for="xp" class="block mb-1 font-medium dark:text-gray-200">XP</label>
                <input type="number" id="xp" name="xp"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                    value="{{ old('xp', $user->xp) }}" min="0">
            </div>

            {{-- Avatar (optional) --}}
            <div>
                <label for="avatar" class="block mb-1 font-medium dark:text-gray-200">Avatar (optional)</label>
                @if ($user->avatar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                            class="w-20 h-20 rounded-full object-cover">
                    </div>
                @endif
                <input type="file" id="avatar" name="avatar" accept="image/*"
                    class="w-full text-gray-700 dark:text-gray-100">
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                    Update User
                </button>
            </div>
        </form>
    </div>
@endsection
