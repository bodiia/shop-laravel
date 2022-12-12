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
    private float $maxProductPrice;

    public function __construct()
    {
        $this->maxProductPrice = Cache::rememberForever('max_product_price', function () {
            $price = new Price(Product::query()->max('price') ?? 0);

            return ceil($price->getValue());
        });
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->filterValueFromRequest(), function (Builder $q) {
            $range = [
                $this->filterValueFromRequest('from', 0) * 100,
                $this->filterValueFromRequest('to', $this->maxProductPrice) * 100,
            ];

            $q->whereBetween('price', $range);
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
            'to' => $this->maxProductPrice,
        ];
    }

    public function filterKeyInRequest(): string
    {
        return 'price';
    }
}
