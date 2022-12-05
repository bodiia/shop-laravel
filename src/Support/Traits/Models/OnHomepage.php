<?php

declare(strict_types=1);

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait OnHomepage
{
    public function homepage(): Builder|static
    {
        return $this->where('on_homepage', true)->orderBy('sorting')->limit(6);
    }
}
