<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderCustomer extends Model
{
    protected $table = 'slider_customer';
    protected $fillable = [
        'outlet_id',
        'image'
    ];
}
