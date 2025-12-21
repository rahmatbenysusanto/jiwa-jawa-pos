<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PecahanUang extends Model
{
    protected $table = 'pecahan_uang';
    protected $fillable = ['kas_rekonsiliasi_id', 'pecahan', 'jumlah'];
}
