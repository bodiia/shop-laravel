<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): View
    {
        $brands = Brand::has('products')->get();
        $categories = Category::has('products')->get();

        $products = Product::query()
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

        $products->each(
            fn (Product $product)
                => $product->setRelation('brand', $brands->firstWhere('id', $product->brand_id))
        );

        return view('catalog.index', compact('brands', 'categories', 'category', 'products'));
    }
}
