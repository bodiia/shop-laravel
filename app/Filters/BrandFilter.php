<?php

declare(strict_types=1);

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

final class BrandFilter extends AbstractFilter
{
    public function apply(Builder $query): Builder
    {
        return $query->when($this->filterValueFromRequest(), function (Builder $q) {
            $q->whereIn('brand_id', $this->filterValueFromRequest());
        });
    }

    public function view(): string
    {
        return 'catalog.filters.brands';
    }

    public function viewTitle(): string
    {
        return __('filters.brands.title');
    }

    public function viewValues(): array
    {
        return Cache::rememberForever('brands_filter', function () {
            return Brand::query()
                ->has('products')
                ->get()
                ->pluck('title', 'id')
                ->toArray();
        });
    }

    public function filterKeyInRequest(): string
    {
        return 'brands';
    }
}
