<?php

declare(strict_types=1);

namespace Support\ViewModels;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Cache\Repository as Cache;

final class HomepageViewModel extends ViewModel
{
    public function __construct(private readonly Cache $cache)
    {
    }

    public function brands(): Collection
    {
        return $this->cache->rememberForever('brand_homepage', function () {
            return Brand::query()->homepage()->get();
        });
    }

    public function products(): Collection
    {
        return $this->cache->rememberForever('product_homepage', function () {
            return Product::query()->has('brand')->with('brand')->homepage()->get();
        });
    }

    public function categories(): Collection
    {
        return $this->cache->rememberForever('category_homepage', function () {
            return Category::query()->homepage()->get();
        });
    }
}
