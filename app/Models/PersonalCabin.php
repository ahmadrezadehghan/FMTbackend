<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCabin extends Model
{
    use HasFactory;

    protected $table = 'personal_cabins';
    protected $fillable = [
        'user_id',
        'phone_number',
        'layout_preferences',
        'last_login',
        'notifications',
    ];

    protected $casts = [
        'layout_preferences' => 'array',
        'notifications' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
