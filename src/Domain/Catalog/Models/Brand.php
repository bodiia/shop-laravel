<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\Builders\BrandBuilder;
use Domain\Catalog\Collections\BrandCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_homepage',
        'sorting',
    ];

    protected static function boot()
    {
        parent::boot();

        collect(['saved', 'deleted'])
            ->each(fn ($event) => static::$event(fn () => cache()->delete('brand_homepage')));
    }

    public function newCollection(array $models = []): BrandCollection
    {
        return new BrandCollection($models);
    }

    public function newEloquentBuilder($query): BrandBuilder
    {
        return new BrandBuilder($query);
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
