<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(static function (Model $model) {
            $model->slug = self::generateUniqueSlug($model);
        });
    }

    protected static function generateUniqueSlug(Model $model, int $matched = 0): string
    {
        $slug = str($model->{ static::slug() })->slug() . ($matched > 0 ? "-$matched" : "");

        $match = $model->query()->where('slug', $slug)->count();

        return $match > 0 ? self::generateUniqueSlug($model, $matched + 1) : $slug;
    }

    abstract public static function slug(): string;
}
