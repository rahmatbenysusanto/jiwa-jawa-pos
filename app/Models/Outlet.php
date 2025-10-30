<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlet';
    protected $fillable = ['name', 'no_hp', 'address', 'logo', 'status', 'wifi'];
}
