<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\DTO\SignInUserDto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

final class SignInUserAction
{
    public function handle(SignInUserDto $signInUserDto): bool
    {
        $credentials = [
            'email' => $signInUserDto->email,
            'password' => $signInUserDto->password,
        ];

        return Auth::attempt($credentials) && Request::session()->regenerate();
    }
}
