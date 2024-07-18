<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'sale_price',
        'images',
        'description',
        'category_id',
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale',
    ];

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
