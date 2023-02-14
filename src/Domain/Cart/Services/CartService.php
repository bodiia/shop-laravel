<?php

declare(strict_types=1);

namespace Domain\Cart\Services;

use Domain\Auth\Models\User;
use Domain\Cart\DTOs\CartProductDto;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
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

    public function findOrCreateCart(?User $currentUser): Cart|Model
    {
        return $this->getCartForCurrentUser($currentUser) ?? $this->createCart($currentUser);
    }

    public function storeProductToCart(CartProductDto $dto): CartItem|Model
    {
        $cart = $this->findOrCreateCart($dto->currentUser);

        /** @var CartItem $createdCartItem */
        $createdCartItem = $cart->cartItems()->updateOrCreate(
            [
                'product_id' => $dto->product->id,
                'stringify_option_values' => collect($dto->optionValues)->sort()->join(':'),
            ],
            [
                'price' => $dto->product->price,
                'quantity' => $dto->quantity,
            ]
        );

        $createdCartItem->optionValues()->sync($dto->optionValues);

        return $createdCartItem;
    }

    public function changeQuantityForCartItem(CartItem $cartItem, int $quantity): bool
    {
        return $cartItem->update(['quantity' => $quantity]);
    }

    public function destroyCartItemFromCart(CartItem $cartItem): ?bool
    {
        return $cartItem->delete();
    }

    public function truncateCart(?User $user): int
    {
        return $this->getCartForCurrentUser($user)?->cartItems()->delete();
    }
}
