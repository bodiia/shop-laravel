<?php

namespace App\Jobs;

use Domain\Product\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FillProductJsonPropertiesJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Product $product)
    {
    }

    public function handle(): void
    {
        $this->product->json_properties = $this->product->properties->transformToKeyValuePairs();
        $this->product->saveQuietly();
    }

    public function uniqueId(): string
    {
        return $this->product->id;
    }
}
