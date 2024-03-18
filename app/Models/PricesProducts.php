<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricesProducts extends Model
{
    protected $table = 'prices_products';

    use HasFactory;
    protected $fillable = [
        'name',
        'url',
        'price_before',
        'price_after',
    ];


}
