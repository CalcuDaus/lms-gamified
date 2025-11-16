<?php

namespace App\Services;

use App\Services\OTPService;
use App\Events\UserRegistered;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthService
{
    /**
     * Create a new class instance.
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register($data)
    {
        $avatarPath = null;
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $avatarPath = $data['avatar']->store('avatars', 'public'); // => "avatars/namafile.jpg"
        }

        session(['register_data' => [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'avatar' => $avatarPath, // hanya path string
            'phone' => $data['phone'],
            'level' => 1,
            'xp' => 0,
            'next_level_xp' => 100,
        ]]);


        UserRegistered::dispatch($data['email']);

        return ['success' => 'Pendaftaran berhasil. Silakan cek email untuk verifikasi akun.'];
    }

    public function verifyOTP($otpCode)
    {
        $registerData = session('register_data');
        $isValid = new OTPService()->verifyOTP($registerData['email'], $otpCode);

        if (!$isValid) {
            return ['error' => 'Kode OTP tidak valid atau telah kedaluwarsa.'];
        }

        // Simpan data user ke database
        $this->userRepository->createUser($registerData);

        // Hapus data pendaftaran dari session
        session()->forget('register_data');

        return ['success' => 'Akun berhasil diverifikasi.'];
    }
    public function login($credentials)
    {
        // Prevent Brute Force Attacks
        $throttleKey = 'login_attempts_' . $credentials['email'];

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return ['error' => 'Terlalu banyak percobaan login. Silakan coba lagi nanti. dalam ' . $seconds . ' detik.'];
        }

        $user = $this->userRepository->getUserByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            return ['error' => $user ? 'Password salah.' : 'Email tidak ditemukan.'];
        }

        RateLimiter::clear($throttleKey);
        Auth::login($user);
        session()->regenerate();
        return [
            'success' => true,
            'user' => $user,
        ];
    }
}
