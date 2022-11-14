<?php

namespace Database\Seeders;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Brand::factory(10)->create();

        Category::factory(10)
            ->has(Product::factory(rand(2, 6)))
            ->create();
    }
}
