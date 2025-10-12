<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionSplitPayment extends Model
{
    protected $table = 'transaction_split_payment';
    protected $guarded = [
        'transaction_id',
        'payment_method_id',
        'price',
        'reff'
    ];
}
