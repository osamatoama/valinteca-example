<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlimShClients extends Model
{

    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_name',
        'client_name',
        'client_email',
        'client_phone',
    ];
}
