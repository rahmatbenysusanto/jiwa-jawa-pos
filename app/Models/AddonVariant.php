<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddonVariant extends Model
{
    protected $table = 'addon_variant';
    protected $fillable = ['addon_id', 'name', 'price', 'deleted_at'];

    public function addon(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Addon::class, 'addon_id', 'id');
    }
}
