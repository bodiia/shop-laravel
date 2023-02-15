<?php

namespace App\Providers;

use App\Listeners\ChangeCartSessionId;
use App\Listeners\SendGreetingEmailToUser;
use Domain\Auth\Events\AfterSessionRegenerate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendGreetingEmailToUser::class,
        ],
        AfterSessionRegenerate::class => [
            ChangeCartSessionId::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
