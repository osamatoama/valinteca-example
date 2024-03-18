<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbayaOrders extends Model
{
    protected $table = 'abaya_orders';
    use HasFactory;
    protected $fillable = [
        'salla_id',
        'reference_id',

    ];
}
