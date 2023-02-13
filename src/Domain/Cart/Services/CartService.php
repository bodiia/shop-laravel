<?php

declare(strict_types=1);

namespace Domain\Cart\Services;

use Domain\Auth\Models\User;
use Domain\Cart\Models\Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class CartService
{
    public function __construct(
        private readonly Session $session,
        private readonly Cache $cache
    ) {
    }

    public function createCart(?User $currentUser): Cart|Model
    {
        $attributes = [
            'session_id' => $this->session->getId(),
            'user_id' => $currentUser?->id,
        ];

        return Cart::query()->create($attributes);
    }

    public function getCartForCurrentUser(?User $currentUser): Cart|Model|null
    {
        return $this->cache->remember('session_' . $this->session->getId(), now()->addHour(), function () use ($currentUser) {
            return Cart::query()
                ->when(
                    $currentUser,
                    fn (Builder $query) => $query->where('user_id', '=', $currentUser->id),
                    fn (Builder $query) => $query->where('session_id', '=', $this->session->getId()),
                )->first();
        });
    }
}
