<?php

declare(strict_types=1);

namespace Domain\Product\ViewModels;

use Domain\Product\Models\Product;
use Illuminate\Support\Collection;
use Support\ViewModels\ViewModel;

final class ProductViewModel extends ViewModel
{
    public function __construct(public Product $product)
    {
    }

    public function options(): Collection
    {
        $this->product->load('optionValues.option');

        return $this->product->optionValues->transformToKeyValuePairs();
    }

    public function viewed(): Collection
    {
        return Product::query()->viewed(current: $this->product)
            ->with('brand')
            ->get();
    }
}
