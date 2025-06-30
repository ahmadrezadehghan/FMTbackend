<?php
// app/Models/Wallet.php

namespace App\Models;

class Wallet extends BaseModel
{
    protected $fillable = [
        'user_id',
        'balance',
        'currency',
        'type'     // e.g., main, trading, bonus
    ];

    protected $casts = [
        'balance' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
