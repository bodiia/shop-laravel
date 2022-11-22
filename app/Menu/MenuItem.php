<?php

declare(strict_types=1);

namespace App\Menu;

use Support\Traits\Makeable;

final class MenuItem
{
    use Makeable;

    public function __construct(
        protected string $url,
        protected string $label
    ) {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isActive(): bool
    {
        $path = parse_url($this->getUrl(), PHP_URL_PATH) ?? '/';

        if ($path === '/') {
            return request()->path() === $path;
        }

        return request()->fullUrlIs($this->getUrl() . '*');
    }
}
