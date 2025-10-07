<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = [
        'outlet_id',
        'category_id',
        'sku',
        'name',
        'price',
        'is_combo',
        'status',
        'description',
        'image',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }
}
