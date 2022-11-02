<?php

declare(strict_types=1);

namespace Domain\Auth\DTO;

final class SignUpUserDto
{
    private function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['password'],
        );
    }
}
