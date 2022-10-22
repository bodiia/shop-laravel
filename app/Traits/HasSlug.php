<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->slug = str($model->{ static::slug() })->slug()->toString();
        });
    }

    abstract public static function slug(): string;
}
