<?php

declare(strict_types=1);

namespace Domain\Auth\Providers;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }

    public function register(): void
    {
        $this->app->bind(StatefulGuard::class, function () {
            return app(AuthManager::class)->guard('web');
        });
    }
}
