<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SepayTransaction extends Model
{
    protected $table = 'sepay_transactions';

    protected $fillable = [
        'transaction_id',
        'ma_don_hang',
        'gateway',
        'account_number',
        'transfer_amount',
        'transfer_type',
        'content',  
        'reference_code',
        'transaction_date',
        'trang_thai',
        'ghi_chu',
        'webhook_idempotency_key',
    ];

    protected $casts = [
        'transfer_amount' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];
}
