<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $fillable = [
        'outlet_id',
        'invoice_number',
        'qty',
        'subtotal',
        'discount',
        'tax',
        'total',
        'payment_method_id',
        'payment_status',
        'transaction_type',
        'note',
        'transaction_date',
        'created_by',
    ];
}
