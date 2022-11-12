<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\DTO\SocialAuthenticationDto;
use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Hash;

final class SocialAuthenticationAction
{
    public function handle(SocialAuthenticationDto $authenticationDto): User
    {
        $attributes = [
            'name' => $authenticationDto->user->getName() ?? $authenticationDto->user->getNickname(),
            'email' => $authenticationDto->user->getEmail(),
            'password' => Hash::make($authenticationDto->user->getEmail()),
        ];

        return User::query()->updateOrCreate(
            [$authenticationDto->socialType . '_id' => $authenticationDto->user->getId()],
            $attributes
        );
    }
}
