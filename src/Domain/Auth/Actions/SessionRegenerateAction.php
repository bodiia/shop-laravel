<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Closure;
use Illuminate\Contracts\Session\Session;
use Domain\Auth\Events\AfterSessionRegenerate;

final class SessionRegenerateAction
{
    public function __construct(private readonly Session $session)
    {
    }

    public function handle(Closure $callback = null): void
    {
        $oldSessionId = $this->session->getId();

        $this->session->invalidate();
        $this->session->regenerateToken();

        if (! is_null($callback)) {
            $callback();
        }

        $newSessionId = $this->session->getId();

        event(new AfterSessionRegenerate($oldSessionId, $newSessionId));
    }
}
