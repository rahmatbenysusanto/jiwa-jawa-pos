<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    public function menuVariant(): HasMany
    {
        return $this->hasMany(MenuVariant::class, 'menu_id');
    }
}
