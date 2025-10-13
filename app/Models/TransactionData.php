<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionData extends Model
{
    protected $table = 'transaction_data';
    protected $fillable = [
        'invoice_number',
        'cart',
        'discountTransaction',
        'paymentMethod',
        'splitPayment'
    ];
}
