<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BrandFactory::new()
            ->count(10)
            ->has(ProductFactory::new()->count(rand(2, 6)))
            ->create();

        CategoryFactory::new()
            ->count(10)
            ->has(ProductFactory::new()->count(rand(2, 6)))
            ->create();
    }
}
