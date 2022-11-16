<?php

declare(strict_types=1);

namespace Support\ViewModels;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;

final class HomepageViewModel extends ViewModel
{
    public function brands(): Collection
    {
        return cache()->rememberForever('brand_homepage', function () {
            return Brand::query()->homepage()->get();
        });
    }

    public function products(): Collection
    {
        return cache()->rememberForever('product_homepage', function () {
            return Product::query()->homepage()->get();
        });
    }

    public function categories(): Collection
    {
        return cache()->rememberForever('category_homepage', function () {
            return Category::query()->homepage()->get();
        });
    }
}
