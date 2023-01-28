<?php

declare(strict_types=1);

namespace Support\Traits\Models;

trait Cacheable
{
    protected static function bootCacheable(): void
    {
        foreach (static::cacheFlushEvents() as $event) {
            static::$event(fn () => static::forgetMultiple());
        }
    }

    private static function forgetMultiple(): void
    {
        foreach (static::cache() as $key) {
            cache()->forget($key);
        }
    }

    protected static function cacheFlushEvents(): array
    {
        return ['saved', 'deleted'];
    }

    abstract protected static function cache(): array;
}
