<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuVariantOption extends Model
{
    protected $table = 'menu_variant_option';
    protected $fillable = [
        'menu_variant_id',
        'name',
        'price_delta',
        'is_default'
    ];
}
