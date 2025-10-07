<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_detail';
    protected $fillable = [
        'transaction_id',
        'menu_id',
        'qty',
        'base_price',
        'price',
        'discount',
        'total',
        'note'
    ];
}
