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
        'min_order_value',
        'max_order_value',
        'start_date',
        'end_date',
        'status',
    ];
}
