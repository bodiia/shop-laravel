<?php

declare(strict_types=1);

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(static function (Model $model) {
            $model->slug = $model->generateUniqueSlug(
                Str::slug($model->{ static::slugableField() })
            );
        });
    }

    protected function generateUniqueSlug(string $slug, int $matched = 0): string
    {
        $uniqueSlugCandidate = $slug . ($matched > 0 ? "-$matched" : "");

        $match = $this->query()->withoutGlobalScopes()
            ->where('slug', $uniqueSlugCandidate)
            ->exists();

        return $match ? $this->generateUniqueSlug($slug, $matched + 1) : $uniqueSlugCandidate;
    }

    abstract protected static function slugableField(): string;
}
