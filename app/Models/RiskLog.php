<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'details',
        'alert_triggered',
    ];

    protected $casts = [
        'alert_triggered' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
