<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = Category::homepage()->get();
        $brands = Brand::homepage()->get();
        $products = Product::homepage()->get();

        return view('index', compact('categories', 'brands', 'products'));
    }
}
