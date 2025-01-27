<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerdabAbayaOrderItems extends Model
{

    use HasFactory;

    protected $fillable = [
        'order_id',
        'salla_order_number',
        'sku',
        'status',
        'quantity',
        'size',
        'notes',
        'order_date',
    ];

    public function order()
    {
        return $this->belongsTo(SerdabAbayaOrders::class);

    }
}
