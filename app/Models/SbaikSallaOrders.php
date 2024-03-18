<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SbaikSallaOrders extends Model
{

    use HasFactory;

    protected $table = 'sbaik_salla_orders';

    protected $fillable = [
        'customer_id',
        'email',
        'mobile',
        'sales_order_number',
        'sales_amount',
        'order_date',
    ];

}
