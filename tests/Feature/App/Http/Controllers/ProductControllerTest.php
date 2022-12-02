<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Database\Factories\ProductFactory;
use Tests\TestCase;

final class ProductControllerTest extends TestCase
{
    public function test_a_product_page_success_response()
    {
        $product = ProductFactory::new()->create();

        $this->get(route('product', $product))
            ->assertOk();
    }
}
