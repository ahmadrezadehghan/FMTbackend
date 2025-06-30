<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    protected static $logAttributes = ['email', 'status'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function wallets()             { return $this->hasMany(Wallet::class); }
    public function bankAccounts()        { return $this->hasMany(BankAccount::class); }
    public function kycDocuments()        { return $this->hasMany(KycDocument::class); }
    public function tradingAccounts()     { return $this->hasMany(TradingAccount::class); }
    public function trades()              { return $this->hasMany(Trade::class); }
    public function ib()                  { return $this->hasOne(IB::class); }
    public function personalCabin()       { return $this->hasOne(PersonalCabin::class); }
    public function demoAccounts()        { return $this->hasMany(DemoAccount::class); }
    public function copyTradesAsFollower(){ return $this->hasMany(CopyTrade::class, 'follower_id'); }
    public function copyTradesAsProvider(){ return $this->hasMany(CopyTrade::class, 'provider_id'); }
    public function notifications()       { return $this->hasMany(Notification::class); }
}
