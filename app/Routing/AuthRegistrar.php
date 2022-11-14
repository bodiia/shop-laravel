<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthenticationController;
use Illuminate\Support\Facades\Route;

final class AuthRegistrar implements RouteRegistrar
{
    public function map(): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(SignInController::class)->group(function () {
                Route::get('/signin', 'index')
                    ->name('signin.index');

                Route::delete('/logout', 'logout')
                    ->name('signin.logout');

                Route::post('/signin', 'handle')
                    ->middleware('throttle:auth')
                    ->name('signin.handle');
            });

            Route::controller(SignUpController::class)->group(function () {
                Route::get('/signup', 'index')
                    ->name('signup.index');

                Route::post('/signup', 'handle')
                    ->middleware('throttle:auth')
                    ->name('signup.handle');
            });

            Route::controller(ForgotPasswordController::class)->group(function () {
                Route::get('/forgot-password', 'index')
                    ->middleware('guest')
                    ->name('forgot.index');

                Route::post('/forgot-password', 'handle')
                    ->middleware('guest')
                    ->name('forgot.handle');
            });

            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('/reset-password/{token}', 'index')
                    ->middleware('guest')
                    ->name('password.reset');

                Route::post('/reset-password', 'handle')
                    ->middleware('guest')
                    ->name('password.reset.handle');
            });

            Route::controller(SocialAuthenticationController::class)->group(function () {
                Route::get('/socialite/{driver}/redirect', 'redirect')
                    ->name('socialite.redirect');

                Route::get('/socialite/{driver}/callback', 'callback')
                    ->name('socialite.callback');
            });
        });
    }
}
