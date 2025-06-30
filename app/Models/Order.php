<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_type',
        'symbol',
        'volume',
        'price',
        'stop_loss',
        'take_profit',
        'status',
        'executed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
