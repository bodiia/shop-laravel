<?php

declare(strict_types=1);

namespace Domain\Auth\Providers;

use Domain\Auth\Actions\RegisterUserAction;
use Domain\Auth\Contracts\RegisterUserContract;
use Illuminate\Support\ServiceProvider;

final class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterUserContract::class => RegisterUserAction::class,
    ];
}
