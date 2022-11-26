<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use App\Models\Product;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Support\ViewModels\ViewModel;

final class CatalogViewModel extends ViewModel
{
    public function __construct(private readonly ?Category $category)
    {
    }

    public function category(): ?Category
    {
        return $this->category;
    }

    public function categories(): Collection
    {
        return Category::query()->has('products')->get();
    }

    public function products(): Paginator
    {
        return Product::query()->with('brand')
            ->when(
                $this->category->exists,
                fn (Builder $query)
                    => $query->whereRelation('categories', 'category_id', '=', $this->category->id)
            )
            ->when(
                request('search'),
                fn (Builder $query)
                    => $query->whereFullText(['title', 'text'], request('search'))
            )
            ->filtered()
            ->sorted()
            ->paginate(6);
    }
}
