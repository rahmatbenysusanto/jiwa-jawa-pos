<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetailVariantAddon extends Model
{
    protected $table = 'transaction_detail_variant_addon';
    protected $fillable = [
        'transaction_detail_id',
        'addon_variant_id',
        'addon_name',
        'addon_price',
        'qty',
        'total_price',
    ];
}
