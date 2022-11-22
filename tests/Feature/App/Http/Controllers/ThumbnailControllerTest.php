<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

final class ThumbnailControllerTest extends TestCase
{
    public function test_a_image_generated_success()
    {
        Storage::fake('images');

        $size = '500x500';
        $method = 'resize';

        config()->set('thumbnail', ['allowed_sizes' => [$size]]);

        $product = ProductFactory::new()->create();

        $this
            ->get($product->makeThumbnail($size, $method))
            ->assertOk();

        Storage::disk('images')->assertExists(
            "products/$method/$size/" . File::basename($product->thumbnail)
        );
    }
}
