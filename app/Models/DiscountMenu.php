<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountMenu extends Model
{
    protected $table = 'discount_menu';
    protected $fillable = ['discount_id', 'menu_id'];

    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
