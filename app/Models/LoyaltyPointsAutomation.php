<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPointsAutomation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'day',
        'page',
        'is_done',
    ];

    protected $casts = [
        'day' => 'date',
        'is_done' => 'boolean',
    ];
}
