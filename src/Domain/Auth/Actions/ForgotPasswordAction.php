<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\DTO\ForgotPasswordDto;
use Illuminate\Support\Facades\Password;

final class ForgotPasswordAction
{
    public function handle(ForgotPasswordDto $forgotPasswordDto): string
    {
        $credentials = ['email' => $forgotPasswordDto->email];

        return Password::sendResetLink($credentials);
    }
}
