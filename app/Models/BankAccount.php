<?php
// app/Models/BankAccount.php

namespace App\Models;

class BankAccount extends BaseModel
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'iban',
        'swift',
        'currency',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
