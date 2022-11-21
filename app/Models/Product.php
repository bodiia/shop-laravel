<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\Traits\Models\Cacheable;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Cacheable;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'price',
        'text',
        'brand_id',
        'on_homepage',
        'sorting',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function scopeHomepage(Builder $query): void
    {
        $query->where('on_homepage', true)->orderBy('sorting')->limit(6);
    }

    public function scopeFiltered(Builder $query): void
    {
        $query->when(request('filters.brands'), function (Builder $q) {
            $q->whereIn('brand_id', request('filters.brands'));
        })->when(request('filters.price'), function (Builder $q) {
            $q->whereBetween('price', [
                request('filters.price.from', 0) * 100,
                request('filters.price.to', 100000) * 100,
            ]);
        });
    }

    public function scopeSorted(Builder $query): void
    {
        $query->when(request('sort'), function (Builder $q) {
            $column = str(request('sort'));

            if ($column->contains(['price', 'title'])) {
                $direction = $column->contains('-') ? 'DESC' : 'ASC';

                $q->orderBy((string) $column->remove('-'), $direction);
            }
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    protected static function cache(): array
    {
        return [
            'product_homepage',
        ];
    }

    protected static function slugableField(): string
    {
        return 'title';
    }
}
