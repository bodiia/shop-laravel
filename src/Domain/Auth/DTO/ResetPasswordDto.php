<?php

declare(strict_types=1);

namespace Domain\Auth\DTO;

use Illuminate\Http\Request;

final class ResetPasswordDto
{
    private function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $token
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->email,
            $request->password,
            $request->token
        );
    }
}
