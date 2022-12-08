<?php

declare(strict_types=1);

namespace Support\Traits\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use ReflectionClass;

trait HasThumbnail
{
    public function makeThumbnail(string $size, string $method = 'resize'): string
    {
        $params = [
            'size' => $size,
            'method' => $method,
            'dirname' => $this->thumbnailDirectory(),
            'filename' => File::basename($this->{ $this->thumbnail() }),
        ];

        return URL::route('thumbnail', $params);
    }

    protected function thumbnail(): string
    {
        return 'thumbnail';
    }

    protected function thumbnailDirectory(): string
    {
        $reflection = new ReflectionClass($this);

        return Str::of($reflection->getShortName())
            ->lower()
            ->plural()
            ->value();
    }
}
