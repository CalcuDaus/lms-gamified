<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function showLoginForm()
    {
        // return view('auth.login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(UserRequest $request)
    {
        $this->authService->register($request->validated());
        return redirect()->route('auth.verify-otp')->with('success', 'Pendaftaran berhasil. Silakan cek email untuk verifikasi akun.');
    }
    public function verifyOTP(Request $request)
    {
        // dd('masuk controller');
        $result = $this->authService->verifyOTP($request->input('otp'));

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('home')->with('success', 'Akun berhasil diverifikasi.');
    }
}
