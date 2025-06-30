<?php
// app/Models/Notification.php

namespace App\Models;

class Notification extends BaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'read_at',
        'data'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'data'    => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
