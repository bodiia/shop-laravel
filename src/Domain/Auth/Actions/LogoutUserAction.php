<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

final class LogoutUserAction
{
    public function handle(): void
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
