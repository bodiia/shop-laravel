<?php

declare(strict_types=1);

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Support\ValueObjects\Price;

final class PriceFilter extends AbstractFilter
{
    public function __construct()
    {
        Cache::rememberForever('max_product_price', function () {
            $price = new Price(Product::query()->max('price') ?? 0);

            return ceil($price->getValue());
        });
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->filterValueFromRequest(), function (Builder $q) {
            $q->whereBetween('price', [
                $this->filterValueFromRequest('from', 0) * 100,
                $this->filterValueFromRequest('to', Cache::get('max_product_price')) * 100,
            ]);
        });
    }

    public function view(): string
    {
        return 'catalog.filters.price';
    }

    public function viewTitle(): string
    {
        return __('filters.price.title');
    }

    public function viewValues(): array
    {
        return [
            'from' => 0,
            'to' => Cache::get('max_product_price'),
        ];
    }

    public function filterKeyInRequest(): string
    {
        return 'price';
    }
}
