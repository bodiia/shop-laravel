<?php

namespace App\Listeners;

use Domain\Auth\Events\AfterSessionRegenerate;
use Domain\Cart\Services\CartService;

class ChangeCartSessionId
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function handle(AfterSessionRegenerate $event): void
    {
        $this->cartService->updateSessionId($event->oldSessionId, $event->newSessionId);
    }
}
