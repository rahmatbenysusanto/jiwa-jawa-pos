<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialUsage extends Model
{
    protected $table = 'material_usage';
    protected $fillable = [
        'outlet_id',
        'material_id',
        'transaction_id',
        'transaction_detail_id',
        'menu_id',
        'variant_detail_id',
        'addon_detail_id',
        'qty',
        'type',
        'note'
    ];

    public function material(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function variantDetail(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MenuVariantOption::class, 'variant_detail_id');
    }

    public function addOnDetail(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AddonVariant::class, 'addon_detail_id');
    }
}
