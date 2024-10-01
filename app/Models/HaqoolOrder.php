<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaqoolOrder extends Model
{

    use HasFactory;

    protected $fillable = [
        'product_name',
        'sku',
        'brand',
        'cost',
        'quantity',
        'total',
        'order_number',
        'order_date',
        'order_status',
        'client_name',
        'client_email',
        'client_phone',
        'client_city',
        'payment_method',
        'invoice_number',
        'salla_order_id',
    ];


    protected $casts = [
        'payload' => 'json'
    ];

    protected $dates  = ['order_date'];

}
