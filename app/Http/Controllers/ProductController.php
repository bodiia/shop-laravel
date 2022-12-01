<?php

namespace App\Http\Controllers;

use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        $product->load('optionValues.option');

        $viewed = Product::query()
            ->where(
                fn (Builder $query)
                    => $query->whereIn('id', session('viewed_products', []))->where('id', '!=', $product->id)
            )
            ->with('brand')
            ->get();

        $options = $product->optionValues->mapToGroups(
            fn (OptionValue $value) => [$value->option->title => $value]
        );

        session()->put('viewed_products.' . $product->id, $product->id);

        return view('product.show', compact('product', 'options', 'viewed'));
    }
}
