<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuRecipeMaterial extends Model
{
    protected $table = 'menu_recipe_material';
    protected $fillable = [
        'menu_id',
        'variant_id',
        'addon_id',
        'material_id',
        'qty',
        'unit'
    ];
}
