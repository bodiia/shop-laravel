<?php

declare(strict_types=1);

namespace Support\ViewModels;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class HomepageViewModel extends ViewModel
{
    public function brands(): Collection
    {
        return Cache::rememberForever('brand_homepage', function () {
            return Brand::query()->homepage()->get();
        });
    }

    public function products(): Collection
    {
        return Cache::rememberForever('product_homepage', function () {
            return Product::query()->has('brand')->with('brand')->homepage()->get();
        });
    }

    public function categories(): Collection
    {
        return Cache::rememberForever('category_homepage', function () {
            return Category::query()->homepage()->get();
        });
    }
}
