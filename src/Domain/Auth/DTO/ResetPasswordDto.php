<?php

declare(strict_types=1);

namespace Domain\Auth\DTO;

final class ResetPasswordDto
{
    private function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $token
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['email'],
            $data['password'],
            $data['token']
        );
    }
}