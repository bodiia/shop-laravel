<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function initialize(string $factory): void
    {
        $factory::new()->count(5)->homepage()->sorting(999)->create();
        $factory::new()->homepage()->sorting(1)->create();
    }

    public function test_a_home_page_success_opened()
    {
        collect([ProductFactory::class, BrandFactory::class, CategoryFactory::class])
            ->each(fn (string $factory) => $this->initialize($factory));

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('categories.0', Category::firstWhere('sorting', 1))
            ->assertViewHas('brands.0', Brand::firstWhere('sorting', 1))
            ->assertViewHas('products.0', Product::firstWhere('sorting', 1));
    }
}
