<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $table = 'menu_category';
    protected $fillable = ['outlet_id', 'name', 'deleted_at'];
}
