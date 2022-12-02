<?php

declare(strict_types=1);

namespace Support\Traits\Models;

trait Cacheable
{
    protected static function bootCacheable(): void
    {
        foreach (static::cacheFlushEvents() as $event) {
            static::$event(static fn () => cache()->deleteMultiple(static::cache()));
        }
    }

    protected static function cacheFlushEvents(): array
    {
        return ['saved', 'deleted'];
    }

    abstract protected static function cache(): array;
}
