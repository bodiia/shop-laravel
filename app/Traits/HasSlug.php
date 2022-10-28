<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(static function (Model $model) {
            $model->slug = $model->generateUniqueSlug(
                $model,
                str($model->{ $model->slug() })->slug()->value()
            );
        });
    }

    protected function generateUniqueSlug(Model $model, string $slug, int $matched = 0): string
    {
        $uniqueSlugCandidate = $slug . ($matched > 0 ? "-$matched" : "");

        $match = $model->query()->withoutGlobalScopes()
            ->where('slug', $uniqueSlugCandidate)
            ->exists();

        return $match ? self::generateUniqueSlug($model, $slug, $matched + 1) : $uniqueSlugCandidate;
    }

    abstract protected function slug(): string;
}
