<?php

declare(strict_types=1);

namespace App\Jobs;

use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

final class ProductPropertiesTest extends TestCase
{
    public function test_a_product_properties_created_successfully()
    {
        $queue = Queue::getFacadeRoot();

        Queue::fake(FillProductJsonPropertiesJob::class);

        $properties = PropertyFactory::new()->count(10)->create();
        $product = ProductFactory::new()
            ->hasAttached($properties, fn () => ['value' => fake()->word()])
            ->create();

        $this->assertEmpty($product->json_properties);

        Queue::swap($queue);
        FillProductJsonPropertiesJob::dispatchSync($product);

        $product->refresh();

        $this->assertNotEmpty($product->json_properties);
    }
}
