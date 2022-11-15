<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\DTO\ResetPasswordDto;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

final class ResetPasswordAction
{
    public function handle(ResetPasswordDto $resetPasswordDto): string
    {
        $credentials = [
            'email' => $resetPasswordDto->email,
            'password' => $resetPasswordDto->password,
            'token' => $resetPasswordDto->token,
        ];

        return Password::reset($credentials, static function (User $user, string $password) {
            $user
                ->forceFill(['password' => Hash::make($password)])
                ->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });
    }
}
