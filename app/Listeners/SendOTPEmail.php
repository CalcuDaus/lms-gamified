<?php

namespace App\Listeners;

use App\Services\OTPService;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\SendOTPNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOTPEmail 
{
    /**
     * Create the event listener.
     */
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $otp = $this->otpService->generateOTP($event->email);
        Notification::route('mail', $event->email)
            ->notify(new SendOTPNotification($otp));
    }
}
