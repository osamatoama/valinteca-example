<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZadlyOrders extends Model
{

    use HasFactory;

    protected $fillable = [
        'customer_id',
        'phone',
        'purchase_date',
        'purchase_product',
        'quantity',
        'amount'
    ];

}
