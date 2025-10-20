<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
    protected $fillable = [
        'outlet_id',
        'number',
        'warehouse_id',
        'warehouse_name',
        'status',
        'qty',
        'order_date',
    ];
}
