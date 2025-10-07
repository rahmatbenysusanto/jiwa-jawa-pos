<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddonVariant extends Model
{
    protected $table = 'addon_variant';
    protected $fillable = ['addon_id', 'name', 'price', 'deleted_at'];
}
