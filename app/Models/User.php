<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'available_balance' => 'float',
    ];

    protected $attributes = [
        'available_balance' => 0.00,
    ];

    // Relationships
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawalCard()
    {
        return $this->hasOne(WithdrawalCard::class);
    }

    // Role
    public function role()
    {
        return $this->role_as === '1' ? 'admin' : 'user';
    }

    // Total invested
    public function getAmountInvestedAttribute()
    {
        return $this->investments()->sum('amount_invested');
    }

    // Total interest earned (only from completed investments)
    // public function getTotalInterestEarnedAttribute()
    // {
    //     return $this->investments()
    //                 ->where('status', 'completed')
    //                 ->sum('profit');
    // }
// public function getTotalInterestEarnedAttribute()
// {
//     return $this->investments
//         ->where('status', 'completed')
//         ->sum(function ($inv) {
//             return $inv->total_profit;
//         });
// }
public function getTotalInterestEarnedAttribute()
{
    return $this->investments()
        ->where('status', 'completed')
        ->get()
        ->sum('total_profit');
}

    // Total approved withdrawals
    public function getTotalWithdrawnAttribute()
    {
        return $this->withdrawals()
                    ->where('status', 'approved')
                    ->sum('amount');
    }

    // Total income = balance + interest
    public function getTotalIncomeAttribute()
    {
        return $this->available_balance + $this->total_interest_earned;
    }

    // Total withdrawals (any status)
    public function getTotalWithdrawalsAttribute()
    {
        return $this->withdrawals()->sum('amount');
    }
}
