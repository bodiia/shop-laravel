<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterUserContract;
use Domain\Auth\DTO\RegisterUserDto;
use Domain\Auth\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

final class RegisterUserAction implements RegisterUserContract
{
    public function handle(RegisterUserDto $registerUserDto): void
    {
        $attributes = [
            'name' => $registerUserDto->name,
            'email' => $registerUserDto->email,
            'password' => Hash::make($registerUserDto->password),
        ];

        /** @var User&Authenticatable $user */
        $user = User::query()->create($attributes);

        event(new Registered($user));

        auth()->login($user);
    }
}
