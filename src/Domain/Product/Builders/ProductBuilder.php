<?php

declare(strict_types=1);

namespace Domain\Product\Builders;

use Domain\Catalog\Facades\Filter;
use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;
use Support\Traits\Models\OnHomepage;

final class ProductBuilder extends Builder
{
    use OnHomepage;

    private const FULL_TEXT_COLUMNS = ['title', 'text'];

    public function withFiltering(): Builder|ProductBuilder
    {
        return Filter::execute($this);
    }

    public function withSorting(): Builder|ProductBuilder
    {
        return Sorter::execute($this);
    }

    public function viewed(Product $current): ProductBuilder
    {
        $viewed = Session::get('viewed_products', []);

        return $this->where(function (Builder $query) use ($current, $viewed) {
            $query->whereIn('id', $viewed)->where('id', '!=', $current->id);
        });
    }

    public function withCategory(?Category $category): ProductBuilder
    {
        return $this->when($category->exists, function (Builder $query) use ($category) {
            $query->whereRelation('categories', 'category_id', '=', $category->id);
        });
    }

    public function withSearch(?string $search): ProductBuilder
    {
        return $this->when($search, function (Builder $query) use ($search) {
            $query->whereFullText(static::FULL_TEXT_COLUMNS, $search);
        });
    }
}
