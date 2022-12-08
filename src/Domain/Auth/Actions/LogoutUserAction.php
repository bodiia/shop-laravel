<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

final class LogoutUserAction
{
    public function handle(): void
    {
        Auth::logout();
        Request::session()->invalidate();
        Request::session()->regenerateToken();
    }
}
