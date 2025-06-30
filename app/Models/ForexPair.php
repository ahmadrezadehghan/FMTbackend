<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForexPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'base_currency',
        'quote_currency',
        'pip_value',
        'min_trade_volume',
        'max_trade_volume',
    ];

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }
}
