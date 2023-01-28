<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorters\Sorter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\Repository as Cache;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(app(Cache::class)),
            new BrandFilter(app(Cache::class)),
        ]);

        $this->app->bind(Sorter::class, function () {
            return new Sorter(['title', 'price']);
        });
    }
}
