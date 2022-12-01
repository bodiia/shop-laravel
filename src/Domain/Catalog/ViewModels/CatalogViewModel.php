<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Support\ViewModels\ViewModel;

final class CatalogViewModel extends ViewModel
{
    public function __construct(public readonly ?Category $category)
    {
    }

    public function categories(): Collection
    {
        return Category::query()->has('products')->get();
    }

    public function products(): Paginator
    {
        return Product::query()->with('brand')
            ->withCategory($this->category)
            ->withSearch(request('search'))
            ->filtered()
            ->sorted()
            ->paginate(6);
    }
}
