<?php

declare(strict_types=1);

namespace Domain\Auth\DTO;

use Illuminate\Http\Request;

final class SignUpUserDto
{
    private function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->name,
            $request->email,
            $request->password,
        );
    }
}
