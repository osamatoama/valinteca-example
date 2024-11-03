<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerdabAbayaOrders extends Model
{

    use HasFactory;


    protected $fillable = [
        'salla_order_id',
        'order_number',
        'order_status',
        'order_date',
        'is_synced',

    ];

    public function items()
    {
        return $this->hasMany(SerdabAbayaOrderItems::class, 'order_id', 'id');
    }
}
