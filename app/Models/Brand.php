<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasThumbnail;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_homepage',
        'sorting',
    ];

    public function scopeHomepage(Builder $query): void
    {
        $query->where('on_homepage', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    protected function slug(): string
    {
        return 'title';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
