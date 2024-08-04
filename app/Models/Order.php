<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'grand_total',
        'final_total',
        'payment_method',
        'payment_status',
        'full_name',
        'phone_number',
        'city',
        'district',
        'address',
        'status',
        'notes'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order_item()
    {
        return $this->hasMany(OrderItem::class);
    }
}
