<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

final class CategoryViewModel
{
    use Makeable;

    public function homepage(): Collection
    {
        return cache()->rememberForever('category_homepage', function () {
            return Category::query()->homepage()->get();
        });
    }
}
