<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

final class CartRegistrar implements RouteRegistrar
{
    public function map(): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

            Route::post('/cart', [CartController::class, 'store'])->name('cart.store');

            Route::delete('/cart/truncate', [CartController::class, 'truncate'])->name('cart.truncate');
        });
    }
}
