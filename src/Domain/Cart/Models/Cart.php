<?php

namespace Domain\Cart\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
    ];

    public function totalPrice(): Attribute
    {
    }

    public function totalQuantity(): Attribute
    {
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
