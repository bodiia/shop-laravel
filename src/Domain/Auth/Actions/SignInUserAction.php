<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Illuminate\Contracts\Auth\StatefulGuard as Auth;
use Domain\Auth\DTO\SignInUserDto;

final class SignInUserAction
{
    public function __construct(
        private readonly Auth $auth,
        private readonly SessionRegenerateAction $regenerateAction
    ) {
    }

    public function handle(SignInUserDto $signInUserDto): bool
    {
        $credentials = [
            'email' => $signInUserDto->email,
            'password' => $signInUserDto->password,
        ];

        if ($attempt = $this->auth->attempt($credentials)) {
            $this->regenerateAction->handle();
        }

        return $attempt;
    }
}
