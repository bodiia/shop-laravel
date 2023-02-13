<?php

namespace App\Http\Controllers;

use Domain\Cart\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {
    }

    public function index(Request $request): View
    {
        $cart = $this->cartService->getCartForCurrentUser($request->user())
            ?: $this->cartService->createCart($request->user());
        $cart->load(['cartItems.optionValues.option', 'cartItems.product']);

        return view('cart.index', compact('cart'));
    }

    public function store(): RedirectResponse
    {
        return back();
    }

    public function truncate(): RedirectResponse
    {
        return back();
    }
}
