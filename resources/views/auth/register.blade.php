<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Create Account</h1>
                <p class="text-gray-600 mt-2">Sign up to get started</p>
            </div>
            <!-- Registration Form -->
            <form method="POST" action="{{ route('auth.register') }}" enctype="multipart/form-data">
                @csrf
                <!-- Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-2 border  rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                        placeholder="Enter your full name"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-2 border  rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                        placeholder="your.email@example.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-2 border  rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('phone') border-red-500 @enderror"
                        placeholder="+62 123 4567 8900"
                    >
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Field -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="role" 
                        name="role" 
                        required
                        class="w-full px-4 py-2 border  rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('role') border-red-500 @enderror"
                    >
                        <option value="">Select your role</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-2 border  rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                        placeholder="Minimum 8 characters"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        class="w-full px-4 py-2 border  rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="Re-enter your password"
                    >
                </div>

                <!-- Avatar Upload Field -->
                <div class="mb-6">
                    <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                        Profile Picture
                    </label>
                    <input 
                        type="file" 
                        id="avatar" 
                        name="avatar" 
                        accept="image/*"
                        class="w-full px-4 py-2 border  rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('avatar') border-red-500 @enderror"
                    >
                    <p class="text-gray-500 text-xs mt-1">Max file size: 4MB</p>
                    @error('avatar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200 focus:ring-4 focus:ring-blue-300"
                >
                    Register
                </button>

                <!-- Login Link -->
                <div class="text-center mt-6">#}}" class="text-blue-600 hover:text-blue-700 font-medium">
                            Login here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>