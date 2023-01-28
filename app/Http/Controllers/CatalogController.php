<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\CatalogViewModel;
use Illuminate\View\View;
use Illuminate\Contracts\Cache\Repository as Cache;

class CatalogController extends Controller
{
    public function __construct(private readonly Cache $cache)
    {
    }

    public function __invoke(?Category $category): View
    {
        return view('catalog.index', new CatalogViewModel($category, $this->cache));
    }
}
