<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Interfaces\Slugable as SlugableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory, Slugable;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
    ];

    public function slugable(): string
    {
        return 'title';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
