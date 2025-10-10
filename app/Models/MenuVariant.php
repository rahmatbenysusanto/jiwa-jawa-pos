<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuVariant extends Model
{
    protected $table = 'menu_variant';
    protected $fillable = [
        'menu_id',
        'name',
        'required'
    ];

    public function menuVariantOptions(): HasMany
    {
        return $this->hasMany(MenuVariantOption::class, 'menu_variant_id');
    }
}
