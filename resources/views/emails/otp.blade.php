<x-mail::message>
# Introduction

Hi ini adakah kode OTP kamu untuk melakukan verifikasi pendaftaran.

<x-mail::button :url="''">
    Button Text : {{ $otp }}
</x-mail::button>

Terimakasih,<br>
{{ config('app.name') }}
</x-mail::message>
