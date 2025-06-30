<?php
// app/Models/Transaction.php

namespace App\Models;

class Transaction extends BaseModel
{
    use LogsActivity;

    protected static $logAttributes = ['status','amount','type'];

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'transaction_date',
        'status',
        'reference',
        'meta'
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount'           => 'decimal:2',
        'meta'             => 'array'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function commissionLog()
    {
        return $this->hasOne(CommissionLog::class);
    }
}
