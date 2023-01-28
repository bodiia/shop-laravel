<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\DTO\SignInUserDto;
use Illuminate\Contracts\Session\Session;

final class SignInUserAction
{
    public function __construct(private readonly Session $session)
    {
    }

    public function handle(SignInUserDto $signInUserDto): bool
    {
        $credentials = [
            'email' => $signInUserDto->email,
            'password' => $signInUserDto->password,
        ];

        return auth()->attempt($credentials) && $this->session->regenerate();
    }
}
