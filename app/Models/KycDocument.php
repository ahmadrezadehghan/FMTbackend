<?php
// app/Models/KycDocument.php

namespace App\Models;

class KycDocument extends BaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'file_path',
        'status',
        'reviewed_at',
        'remarks'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
