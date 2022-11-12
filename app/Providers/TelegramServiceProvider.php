<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Services\Telegram\TelegramBot;

class TelegramServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TelegramBot::class, function () {
            return new TelegramBot(
                config('services.telegram.token'),
                config('services.telegram.channel_id')
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
