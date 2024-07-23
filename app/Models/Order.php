<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'grand_total',
        'final_total',
        'payment_method',
        'payment_status',
        'status',
        'full_name',
        'phone_number',
        'city',
        'district',
        'address',
        'status',
        'notes'
    ];
}
