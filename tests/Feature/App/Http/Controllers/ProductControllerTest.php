<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\FillProductJsonProperties;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Tests\TestCase;

final class ProductControllerTest extends TestCase
{
    public function test_a_product_page_success_response()
    {
        OptionFactory::new()->count(2)->create();

        $product = ProductFactory::new()
            ->hasAttached(
                OptionValueFactory::new()->count(10)->create()
            )
            ->hasAttached(PropertyFactory::new()->count(2)->create(), fn () => ['value' => ucfirst(fake()->word())])
            ->afterCreating(fn ($product) => dispatch(new FillProductJsonProperties($product)))
            ->create();

        $this->get(route('product', $product))
            ->assertOk();
    }
}
