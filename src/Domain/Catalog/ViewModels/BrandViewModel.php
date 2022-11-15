<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

final class BrandViewModel
{
    use Makeable;

    public function homepage(): Collection
    {
        return cache()->rememberForever('brand_homepage', function () {
            return Brand::query()->homepage()->get();
        });
    }
}
