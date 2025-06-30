<?php
// app/Models/TradingAccount.php

namespace App\Models;

class TradingAccount extends BaseModel
{
    protected $fillable = [
        'user_id',
        'account_number',
        'server',
        'type',       // demo|real
        'leverage',
        'base_currency',
        'status',     // active|inactive
        'platform'    // mt4|mt5
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class, 'trading_account_id');
    }
}
