<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login.form');
    Route::post('/login', 'signin')->name('login.signin');

    Route::get('/signup', 'showRegisterForm')->name('register.form');
    Route::post('/signup', 'signup')->name('register.signup');

    Route::delete('/logout', 'logout')->name('logout');
});
