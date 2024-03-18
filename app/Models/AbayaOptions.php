<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbayaOptions extends Model
{
    protected $table = 'abaya_options';
    use HasFactory;
    protected $fillable = [
        'option_id',
        'name',
    ];
}
