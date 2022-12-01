<?php

declare(strict_types=1);

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait HomepageDisplay
{
    public function scopeHomepage(Builder $query): void
    {
        $query->where('on_homepage', true)->orderBy('sorting')->limit(6);
    }
}
