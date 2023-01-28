<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Collection;
use Support\ViewModels\ViewModel;

final class CatalogViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Category $category,
        private readonly Cache $cache
    ) {
    }

    public function categories(): Collection
    {
        return $this->cache->rememberForever('categories', static function () {
            return Category::query()->has('products')->get();
        });
    }

    public function products(): Paginator
    {
        return Product::query()
            ->with('brand')
            ->withCategory($this->category)
            ->withSearch(request('search'))
            ->withFiltering()
            ->withSorting()
            ->paginate(6);
    }
}
