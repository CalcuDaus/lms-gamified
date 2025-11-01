<?php

namespace App\Services;

use App\Models\EmailVerification;
use Illuminate\Container\Attributes\Cache;

class OTPService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function generateOTP($email)
    {
        // $key = 'otp_ratelimit_' . $email;
        // if(Cache::has($key)){
        //     throw new \Exception('Terlalu banyak permintaan. Silakan coba lagi nanti.');
        // }
        // Cache::put($key, true, now()->addMinute());


        $otpCode = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        /* fungsi updateOrCreate untuk menyimpan atau memperbarui OTP di database 
        laravel akan mengecek apakah ada record dengan email yang sama
        jika ada, maka akan diperbarui dengan OTP baru dan waktu kedaluwarsa baru
        jika tidak ada, maka akan dibuat record baru */
        EmailVerification::updateOrCreate(
            ['email' => $email],
            ['otp_code' => $otpCode, 'expires_at' => $expiresAt]
        );

        return $otpCode;
    }
    public function verifyOTP($email, $otpCode)
    {
        $record = EmailVerification::where('email', $email)
                    ->where('otp_code', $otpCode)
                    ->first();

        if (!$record || now()->greaterThan($record->expires_at)) {
            return false; // OTP tidak valid atau kedaluwarsa
        }

        // Jika OTP valid, hapus recordnya
        $record->delete();
        return true;
    }
}
