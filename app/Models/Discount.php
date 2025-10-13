<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount';
    protected $fillable = [
        'outlet_id',
        'menu_id',
        'name',
        'code',
        'scope',
        'type',
        'status',
        'value',
        'max_value',
        'min_transaction_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'deleted_at'
    ];
}
