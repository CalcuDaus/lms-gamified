<x-mail::message>
# Welcome to {{ config('app.name') }}

Here is your OTP code for verification.

<x-mail::button :url="''">
    {{ $otp }}
</x-mail::button>

Thank you,<br>
</x-mail::message>
