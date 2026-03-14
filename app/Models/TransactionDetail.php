<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_detail';
    protected $fillable = [
        'transaction_id',
        'menu_id',
        'qty',
        'hpp',
        'base_price',
        'price',
        'discount',
        'total',
        'note'
    ];

    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TransactionDetailVariant::class, 'transaction_detail_id');
    }

    public function addons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TransactionDetailVariantAddon::class, 'transaction_detail_id');
    }
}
