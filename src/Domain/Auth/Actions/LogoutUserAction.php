<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Illuminate\Contracts\Session\Session;

final class LogoutUserAction
{
    public function __construct(private readonly Session $session)
    {
    }

    public function handle(): void
    {
        auth()->logout();
        $this->session->invalidate();
        $this->session->regenerateToken();
    }
}
