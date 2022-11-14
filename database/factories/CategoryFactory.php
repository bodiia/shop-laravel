<?php

namespace Database\Factories;

use Database\Factories\Traits\HasHomepageStates;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    use HasHomepageStates;

    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'on_homepage' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
