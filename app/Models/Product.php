<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasThumbnail;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'price',
        'brand_id',
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

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
