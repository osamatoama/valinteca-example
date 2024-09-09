<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{

    use HasFactory;

    protected $fillable = [
        'salla_id',
        'order_id',
        'code',
        'product_name',
        'status',
        'order_date',
    ];
}
