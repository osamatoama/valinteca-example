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
        'payload',
    ];

    protected $casts = [
        'payload' => 'json',
    ];
}
