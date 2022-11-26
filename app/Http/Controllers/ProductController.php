<?php

namespace App\Http\Controllers;

use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        $product->load('optionValues.option');

        $viewed = Product::query()->whereIn('id', session('viewed_products', []))->get();

        $options = $product->optionValues->mapToGroups(function (OptionValue $value) {
            return [$value->option->title => $value];
        });

        session()->put('viewed_products.' . $product->id, $product->id);

        return view('product.show', compact('product', 'options', 'viewed'));
    }
}
