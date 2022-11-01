<?php

declare(strict_types=1);

namespace Domain\Auth\DTO;

use Laravel\Socialite\Contracts\User as SocialUser;

final class SocialAuthenticationDto
{
    private function __construct(
        public readonly string $socialType,
        public readonly SocialUser $user
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['type'],
            $data['user']
        );
    }
}
