<?php

declare(strict_types=1);

namespace App\Traits;

trait Slugable
{
    protected static function bootSlugable(): void
    {
        static::creating(function (self $model) {
            $field = $model->slugable();
            $model->slug = str($model->$field)->slug()->toString();
        });
    }

    abstract public function slugable(): string;
}
