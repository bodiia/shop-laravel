<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): View
    {
        $categories = Category::query()->has('products')->get();

        $products = Product::query()->with('brand')
            ->when(
                $category->exists,
                fn (Builder $query)
                    => $query->whereRelation('categories', 'category_id', '=', $category->id)
            )
            ->when(
                request('search'),
                fn (Builder $query)
                    => $query->whereFullText(['title', 'text'], request('search'))
            )
            ->filtered()
            ->sorted()
            ->paginate(6);

        return view('catalog.index', compact('category', 'categories', 'products'));
    }
}
