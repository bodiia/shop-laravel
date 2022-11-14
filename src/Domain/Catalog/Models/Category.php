<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\HasSlug;

class Category extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
