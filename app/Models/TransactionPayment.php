<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionPayment extends Model
{
    protected $table = 'transaction_payment';
    protected $fillable = [
        'invoice_number',
        'payment_method_id',
        'reff_id',
        'data'
    ];
}
