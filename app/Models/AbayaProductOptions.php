<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbayaProductOptions extends Model
{

    protected $table = 'abaya_product_options';

    use HasFactory;

    protected $fillable = [
        'reference_id',
        'product_id',
        'option_id',
        'value',
        'quantity',
    ];
}
