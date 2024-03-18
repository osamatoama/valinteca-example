<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbayaProducts extends Model
{

    protected $table = 'abaya_products';

    use HasFactory;

    protected $fillable = [
        'salla_id',
        'name',
        'thumbnail'
    ];

    public function options()
    {
        return $this->hasMany(AbayaProductOptions::class, 'product_id', 'salla_id');

    }
}
