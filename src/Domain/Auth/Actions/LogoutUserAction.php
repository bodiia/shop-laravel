<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

final class LogoutUserAction
{
    public function __construct(private readonly SessionRegenerateAction $regenerateAction)
    {
    }

    public function handle(): void
    {
        $this->regenerateAction->handle(fn () => auth()->logout());
    }
}
