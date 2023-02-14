<?php

namespace Domain\Cart\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\ValueObjects\Price;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
    ];

    public function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => new Price($this->cartItems->sum(fn ($cartItem) => $cartItem->amount_price->getRaw()))
        );
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
