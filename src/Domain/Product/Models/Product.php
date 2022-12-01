<?php

namespace Domain\Product\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Builders\ProductBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\Traits\Models\Cacheable;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;
use Support\Traits\Models\HomepageDisplay;

/**
 * @method static ProductBuilder query()
 */
class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Cacheable;
    use HomepageDisplay;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'price',
        'text',
        'brand_id',
        'on_homepage',
        'sorting',
        'json_properties',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function newEloquentBuilder($query): ProductBuilder
    {
        return new ProductBuilder($query);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    protected static function cache(): array
    {
        return [
            'product_homepage',
            'max_product_price',
        ];
    }

    protected static function slugableField(): string
    {
        return 'title';
    }
}
