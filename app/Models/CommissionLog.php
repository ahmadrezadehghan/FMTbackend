<?php
// app/Models/CommissionLog.php

namespace App\Models;

class CommissionLog extends BaseModel
{
    protected $fillable = [
        'ib_id',
        'transaction_id',
        'amount',
        'currency',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime'
    ];

    public function ib()
    {
        return $this->belongsTo(IB::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
