<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'gift_id',
        'payer_name',
        'amount',
        'status',
        'payment_gateway_id',
        'pix_code',
    ];

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }
}
