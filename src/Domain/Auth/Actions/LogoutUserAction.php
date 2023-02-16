<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Illuminate\Contracts\Auth\StatefulGuard as Auth;

final class LogoutUserAction
{
    public function __construct(
        private readonly Auth $auth,
        private readonly SessionRegenerateAction $regenerateAction
    ) {
    }

    public function handle(): void
    {
        $this->regenerateAction->handle(fn () => $this->auth->logout());
    }
}
