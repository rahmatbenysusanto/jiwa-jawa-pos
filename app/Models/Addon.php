<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $table = 'addon';
    protected $fillable = ['outlet_id', 'name', 'deleted_at'];

    public function addonVariant(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AddonVariant::class, 'addon_id', 'id');
    }
}
