<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\DTO\SignUpUserDto;
use Domain\Auth\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

final class SignUpUserAction
{
    public function handle(SignUpUserDto $signupUserDto): void
    {
        $attributes = [
            'name' => $signupUserDto->name,
            'email' => $signupUserDto->email,
            'password' => Hash::make($signupUserDto->password),
        ];

        /** @var User&Authenticatable $user */
        $user = User::query()->create($attributes);

        event(new Registered($user));

        auth()->login($user);
    }
}
