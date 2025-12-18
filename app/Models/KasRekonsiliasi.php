<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
