<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\CatalogViewModel;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): View
    {
        return view('catalog.index', new CatalogViewModel($category));
    }
}
