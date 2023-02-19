<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CatalogViewMiddleware;
use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\CatalogViewModel;
use Illuminate\View\View;
use Illuminate\Contracts\Cache\Repository as Cache;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Middleware('web')]
class CatalogController extends Controller
{
    public function __construct(private readonly Cache $cache)
    {
    }

    #[Get(uri: 'catalog/{category:slug?}', name: 'catalog', middleware: CatalogViewMiddleware::class)]
    public function __invoke(?Category $category): View
    {
        return view('catalog.index', new CatalogViewModel($category, $this->cache));
    }
}
