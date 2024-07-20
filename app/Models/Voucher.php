<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'usage_limit',
        'start_date',
        'end_date',
        'status',
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'voucher_products', 'voucher_id', 'product_id');
    }
}
