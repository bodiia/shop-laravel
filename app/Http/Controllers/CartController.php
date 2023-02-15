<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductToCartRequest;
use Domain\Cart\DTOs\CartProductDto;
use Domain\Cart\Models\CartItem;
use Domain\Cart\Services\CartService;
use Domain\Product\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {
    }

    public function index(): View
    {
        $cart = $this->cartService->findOrCreateCart()
            ->load(['cartItems.optionValues.option', 'cartItems.product']);

        return view('cart.index', compact('cart'));
    }

    public function store(StoreProductToCartRequest $request): RedirectResponse
    {
        $this->cartService->storeProductToCart(
            CartProductDto::fromArray([...$request->validated(),
                'product' => Product::query()->find($request->validated('product_id')),
            ])
        );

        return to_route('cart.index');
    }

    public function quantity(CartItem $cartItem, Request $request): RedirectResponse
    {
        $attributes = $request->validate(['quantity' => 'required|int|min:1|max:100']);

        $this->cartService->changeQuantityForCartItem(
            $cartItem,
            (int) $attributes['quantity']
        );

        return back();
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $this->cartService->destroyCartItemFromCart($cartItem);

        return back();
    }

    public function truncate(): RedirectResponse
    {
        $this->cartService->truncateCart();

        return back();
    }
}
