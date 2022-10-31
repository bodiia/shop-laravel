<?php

declare(strict_types=1);

namespace App\Routing;

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

final class AppRegistrar
{
    public function map(): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/', HomeController::class)->name('home');
        });
    }
}
