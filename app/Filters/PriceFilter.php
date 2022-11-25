<?php

declare(strict_types=1);

namespace App\Filters;

use App\Models\Product;
use Domain\Catalog\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Support\ValueObjects\Price;

final class PriceFilter extends AbstractFilter
{
    public function __construct()
    {
        cache()->rememberForever('max_product_price', function () {
            $price = new Price(Product::query()->max('price') ?? 0);

            return ceil($price->getValue());
        });
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->filterValueFromRequest(), function (Builder $q) {
            $q->whereBetween('price', [
                $this->filterValueFromRequest('from', 0) * 100,
                $this->filterValueFromRequest('to', cache('max_product_price')) * 100,
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
            'to' => cache('max_product_price'),
        ];
    }

    public function filterKeyInRequest(): string
    {
        return 'price';
    }
}
