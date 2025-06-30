<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IB extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commission_rate',
        'referral_code',
        'total_referred',
        'earnings',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
