<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Domain\Product\ViewModels\ProductViewModel;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        Session::put('viewed_products.' . $product->id, $product->id);

        return view('product.show', new ProductViewModel($product));
    }
}
