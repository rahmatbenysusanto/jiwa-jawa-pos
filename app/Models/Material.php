<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'material';
    protected $fillable = [
        'outlet_id',
        'category_id',
        'name',
        'sku',
        'unit_id',
        'base_unit_id',
        'conversion_value',
        'min_stock',
        'price',
        'description',
        'image',
        'status',
        'deleted_at',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MaterialUnit::class, 'unit_id');
    }

    public function baseUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MaterialUnit::class, 'base_unit_id');
    }
}
