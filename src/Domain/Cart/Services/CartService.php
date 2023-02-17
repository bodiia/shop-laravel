<?php

declare(strict_types=1);

namespace Domain\Cart\Services;

use Domain\Auth\Models\User;
use Domain\Cart\DTOs\CartProductDto;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Illuminate\Contracts\Auth\StatefulGuard as Auth;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class CartService
{
    public function __construct(
        private readonly Auth $auth,
        private readonly Cache $cache,
        private readonly Session $session
    ) {
    }

    private function prepareAttributes(string $sessionId): array
    {
        $attributes = [
            'session_id' => $sessionId
        ];

        if ($this->auth->check()) {
            $attributes['user_id'] = $this->auth->id();
        }

        return $attributes;
    }

    public function createCart(): Cart|Model
    {
        return Cart::query()->create($this->prepareAttributes($this->session->getId()));
    }

    public function getCartForCurrentUser(?User $user): Cart|Model|null
    {
        return $this->cache->remember('session_' . $this->session->getId(), now()->addHour(), function () use ($user) {
            return Cart::query()
                ->when(
                    $user,
                    fn (Builder $query) => $query->where('user_id', '=', $user->getKey()),
                    fn (Builder $query) => $query->where('session_id', '=', $this->session->getId()),
                )->first();
        });
    }

    public function findOrCreateCart(): Cart|Model
    {
        return $this->getCartForCurrentUser($this->auth->user()) ?? $this->createCart();
    }

    public function storeProductToCart(CartProductDto $dto): CartItem|Model
    {
        $cart = $this->findOrCreateCart();

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

    public function truncateCart(): int
    {
        return $this->getCartForCurrentUser($this->auth->user())?->cartItems()->delete();
    }

    public function updateSessionId(string $old, string $new): void
    {
        Cart::query()->where('session_id', '=', $old)->update($this->prepareAttributes($new));
    }
}
