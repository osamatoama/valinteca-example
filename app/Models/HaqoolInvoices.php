<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaqoolInvoices extends Model
{

    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'invoice_number',
        'invoice_type',
        'invoice_date',
        'sub_total',
        'discount',
        'shipping',
        'vat',
        'total',
    ];

}
