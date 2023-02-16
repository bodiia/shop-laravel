<?php

namespace Database\Seeders;

use App\Jobs\FillProductJsonProperties;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $properties = PropertyFactory::new()->count(10)->create();

        OptionFactory::new()->count(2)->create();

        $optionsValues = OptionValueFactory::new()->count(10)->create();

        BrandFactory::new()
            ->count(10)
            ->has(
                ProductFactory::new()
                    ->count(rand(2, 6))
                    ->hasAttached($optionsValues)
                    ->hasAttached($properties, function () {
                        return ['value' => ucfirst(fake()->word())];
                    })
                    ->afterCreating(fn ($product) => dispatch(new FillProductJsonProperties($product)))
            )
            ->create();

        CategoryFactory::new()
            ->count(10)
            ->has(
                ProductFactory::new()
                    ->count(rand(2, 6))
                    ->hasAttached($optionsValues)
                    ->hasAttached($properties, function () {
                        return ['value' => ucfirst(fake()->word())];
                    })
                    ->afterCreating(fn ($product) => dispatch(new FillProductJsonProperties($product)))
            )
            ->create();
    }
}
