<?php

namespace Database\Factories;

use Database\Factories\Traits\HasHomepageStates;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    use HasHomepageStates;

    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
            'thumbnail' => $this->faker->imageCopy('brands', 'images/brands'),
            'on_homepage' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
