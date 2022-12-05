<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\DTO\SignUpUserDto;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

final class SignUpUserAction
{
    public function handle(SignUpUserDto $signupUserDto): User
    {
        $attributes = [
            'name' => $signupUserDto->name,
            'email' => $signupUserDto->email,
            'password' => Hash::make($signupUserDto->password),
        ];

        event(new Registered($user = User::query()->create($attributes)));

        return $user;
    }
}
