<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\Builders\BrandBuilder;
use Domain\Catalog\Collections\BrandCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\Cacheable;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

/**
 * @method static Brand|BrandBuilder query()
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Cacheable;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_homepage',
        'sorting',
    ];

    public function newCollection(array $models = []): BrandCollection
    {
        return new BrandCollection($models);
    }

    public function newEloquentBuilder($query): BrandBuilder
    {
        return new BrandBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected static function cacheKeys(): array
    {
        return ['brand_homepage'];
    }

    protected function slug(): string
    {
        return 'title';
    }
}
