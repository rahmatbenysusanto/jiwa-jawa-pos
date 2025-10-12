<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    protected $table = 'material_category';
    protected $fillable = [
        'outlet_id',
        'name',
        'deleted_at'
    ];
}
