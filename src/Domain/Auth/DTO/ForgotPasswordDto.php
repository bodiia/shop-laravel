<?php

declare(strict_types=1);

namespace Domain\Auth\DTO;

final class ForgotPasswordDto
{
    private function __construct(
        public readonly string $email
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['email']
        );
    }
}
