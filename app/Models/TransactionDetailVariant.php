<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetailVariant extends Model
{
    protected $table = 'transaction_detail_variant';
    protected $fillable = [
        'transaction_detail_id',
        'menu_variant_option_id',
        'variant_name',
        'variant_value',
        'variant_price',
    ];
}
