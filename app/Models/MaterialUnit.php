<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialUnit extends Model
{
    protected $table = 'material_unit';
    protected $fillable = [
        'name',
        'symbol',
    ];
}
