<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function showVerifyOTPForm()
    {
        return view('auth.verify-otp');
    }

    public function login(AuthRequest $request)
    {
        $result = $this->authService->login($request->validated());
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }
        return redirect()->route($result['role'] . '.dashboard')->with('success', 'Login successful.');
    }
    public function register(UserRequest $request)
    {
        $this->authService->register($request->validated());
        return redirect()->route('verify-otp')->with('success', 'Registration successful. Please check your email for the OTP code.');
    }
    public function verifyOTP(Request $request)
    {
        $result = $this->authService->verifyOTP($request->input('otp'));
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }
        return redirect()->route('student.dashboard')->with('success', 'Your account has been verified.');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
