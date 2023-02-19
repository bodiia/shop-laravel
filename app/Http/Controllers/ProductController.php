<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Domain\Product\ViewModels\ProductViewModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Middleware('web')]
class ProductController extends Controller
{
    public function __construct(private readonly Session $session)
    {
    }

    #[Get(uri: 'product/{product:slug}', name: 'product')]
    public function __invoke(Product $product): View
    {
        $this->session->put('viewed_products.' . $product->id, $product->id);

        return view('product.show', new ProductViewModel($product));
    }
}
