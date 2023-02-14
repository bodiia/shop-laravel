<?php

declare(strict_types=1);

use Domain\Auth\Models\User;
use Domain\Cart\Models\Cart;
use Domain\Cart\Services\CartService;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Models\Category;
use Support\Flash\Flash;

if (! function_exists('flash')) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}

if (! function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->getFilters();
    }
}

if (! function_exists('is_catalog_view')) {
    function is_catalog_view(string $type, string $default = 'grid'): bool
    {
        return session('view', $default) === $type;
    }
}

if (! function_exists('filter_url')) {
    function filter_url(?Category $category, array $queryParams): string
    {
        return route('catalog', [
            ...request()->only(['sort', 'filters']),
            ...$queryParams,
            'category' => $category,
        ]);
    }
}

if (! function_exists('get_current_cart')) {
    function get_current_cart(?User $user): ?Cart
    {
        return app(CartService::class)->getCartForCurrentUser($user);
    }
}
