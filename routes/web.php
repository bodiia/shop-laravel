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

    Route::get('/forgot-password', 'forgot')
        ->middleware('guest')
        ->name('password.request');

    Route::post('/forgot-password', 'forgotPassword')
        ->middleware('guest')
        ->name('password.email');

    Route::get('/reset-password/{token}', 'reset')
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', 'resetPassword')
        ->middleware('guest')
        ->name('password.update');

    Route::get('/socialite/github/redirect', 'githubRedirect')
        ->name('socialite.github');

    Route::get('/socialite/github/callback', 'github')
        ->name('socialite.github.callback');
});
