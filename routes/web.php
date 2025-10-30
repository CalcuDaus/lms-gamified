<?php

use Illuminate\Support\Facades\Route;
use App\Services\HelloWorld;


Route::get('/', function () {
    return view('layout.app');
});
Route::get('/hello', function (HelloWorld $hello) {
    dd($hello->greet());
});