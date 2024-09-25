<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestShieldOrder extends Model
{

    use HasFactory;

    protected $fillable = [
        'salla_order_id',
        'order_number',
        'order_date',
        'order_status',
        'client_name',
        'client_phone',
        'client_city',
        'client_country',
        'payment_method',
        'order_total',
        'total_discount',
        'payload',
        'shipping_country',
        'coupon',
        'shipping_city',
    ];
}
