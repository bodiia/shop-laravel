<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Domain\Product\ViewModels\ProductViewModel;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        session()->put('viewed_products.' . $product->id, $product->id);

        return view('product.show', new ProductViewModel($product));
    }
}
