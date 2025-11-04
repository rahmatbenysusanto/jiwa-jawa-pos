<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $fillable = [
        'outlet_id',
        'invoice_number',
        'order_number',
        'qty',
        'subtotal',
        'discount',
        'tax',
        'total',
        'transaction_status',
        'payment_method_id',
        'payment_status',
        'transaction_type',
        'transaction_delivery',
        'note',
        'transaction_date',
        'created_by',
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
