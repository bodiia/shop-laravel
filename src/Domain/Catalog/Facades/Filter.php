<?php

declare(strict_types=1);

namespace Domain\Catalog\Facades;

use Domain\Catalog\Filters\FilterManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Builder execute(Builder $builder)
 */
final class Filter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FilterManager::class;
    }
}
