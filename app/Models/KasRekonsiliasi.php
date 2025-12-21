<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasRekonsiliasi extends Model
{
    protected $table = 'kas_rekonsiliasi';
    protected $fillable = [
        'modal_awal',
        'modal_akhir',
        'cash',
        'qris',
        'debit',
        'laba_kotor',
        'laba_bersih',
        'tanggal',
        'created_by',
        'selisih',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
