<?php

namespace Database\Factories;

use App\Models\Product;
use Database\Factories\Traits\HasHomepageStates;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    use HasHomepageStates;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'thumbnail' => $this->faker->imageCopy('products', 'images/products'),
            'price' => $this->faker->numberBetween(1000, 100000),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'on_homepage' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
