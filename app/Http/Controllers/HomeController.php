<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = CategoryViewModel::make()->homepage();
        $brands = BrandViewModel::make()->homepage();
        $products = Product::homepage()->get();

        return view('index', compact('categories', 'brands', 'products'));
    }
}
