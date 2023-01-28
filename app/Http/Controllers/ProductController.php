<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Domain\Product\ViewModels\ProductViewModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private readonly Session $session)
    {
    }

    public function __invoke(Product $product): View
    {
        $this->session->put('viewed_products.' . $product->id, $product->id);

        return view('product.show', new ProductViewModel($product));
    }
}
