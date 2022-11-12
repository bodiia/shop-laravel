<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;

final class AppRegistrar implements RouteRegistrar
{
    public function map(): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/', HomeController::class)->name('home');

            Route::get('/storage/images/{dirname}/{method}/{size}/{filename}', ThumbnailController::class)
                ->where('method', 'resize|crop|fit')
                ->where('size', '\d+x\d+')
                ->where('filename', '.+\.(png|jpg|gif|bmp|jpeg)$')
                ->name('thumbnail');
        });
    }
}
