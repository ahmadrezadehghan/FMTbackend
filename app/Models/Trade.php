<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'forex_pair_id',
        'order_type',
        'volume',
        'price_open',
        'price_close',
        'stop_loss',
        'take_profit',
        'status',
        'opened_at',
        'closed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forexPair()
    {
        return $this->belongsTo(ForexPair::class);
    }
}
