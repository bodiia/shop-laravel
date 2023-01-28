<?php

declare(strict_types=1);

namespace Support\Traits\Models;

use ReflectionClass;

trait HasThumbnail
{
    public function makeThumbnail(string $size, string $method = 'resize'): string
    {
        $params = [
            'size' => $size,
            'method' => $method,
            'dirname' => $this->thumbnailDirectory(),
            'filename' => basename($this->{ $this->thumbnail() }),
        ];

        return url()->route('thumbnail', $params);
    }

    protected function thumbnail(): string
    {
        return 'thumbnail';
    }

    protected function thumbnailDirectory(): string
    {
        $reflection = new ReflectionClass($this);

        return str($reflection->getShortName())
            ->lower()
            ->plural()
            ->value();
    }
}
