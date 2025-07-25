<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketData extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'price',
        'bid',
        'ask',
        'volume',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];
}
