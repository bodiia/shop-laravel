<?php

declare(strict_types=1);

namespace Domain\Cart\DTOs;

use Domain\Auth\Models\User;
use Domain\Product\Models\Product;

final class CartProductDto
{
    public function __construct(
        public readonly Product $product,
        public readonly ?int $quantity,
        /** @var array<int> $optionValues */
        public readonly ?array $optionValues,
        public readonly ?User $currentUser
    ) {
    }

    public static function fromArray(array $attributes): self
    {
        return new self(
            $attributes['product'],
            (int) $attributes['quantity'] ?? 1,
            $attributes['option_values'] ?? [],
            $attributes['current_user_id']
        );
    }
}
