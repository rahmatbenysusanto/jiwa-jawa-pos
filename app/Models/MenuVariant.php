<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuVariant extends Model
{
    protected $table = 'menu_variant';
    protected $fillable = [
        'menu_id',
        'name',
        'required'
    ];
}
