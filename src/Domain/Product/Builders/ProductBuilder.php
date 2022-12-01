<?php

declare(strict_types=1);

namespace Domain\Product\Builders;

use Domain\Catalog\Facades\Filter;
use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;

final class ProductBuilder extends Builder
{
    public function filtered(): Builder|ProductBuilder
    {
        return Filter::execute($this);
    }

    public function sorted(): Builder|ProductBuilder
    {
        return Sorter::execute($this);
    }

    public function viewed(Product $current): ProductBuilder
    {
        return $this->where(
            fn (Builder $query)
                => $query->whereIn('id', session('viewed_products', []))->where('id', '!=', $current->id)
        );
    }

    public function withCategory(Category $category): ProductBuilder
    {
        return $this->when(
            $category->exists,
            fn (Builder $query)
              => $query->whereRelation('categories', 'category_id', '=', $category->id)
        );
    }

    public function withSearch(?string $search): ProductBuilder
    {
        return $this->when(
            $search,
            fn (Builder $query)
                => $query->whereFullText(['title', 'text'], $search)
        );
    }
}
