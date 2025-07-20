<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Investment extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_WITHDRAWN = 'withdrawn';
    const STATUS_COMPLETED = 'completed';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function getDueAttribute()
    {
        return now()->gte(Carbon::parse($this->end_date));
    }

    public function getIsWithdrawableAttribute()
    {
        return $this->due;
    }

    public function getAvailableProfitAttribute()
    {
        return $this->total_profit - $this->withdrawals->sum('amount');
    }

    public function getIsFullyWithdrawnAttribute()
    {
        return $this->status === 'withdrawn' || $this->status === 'completed' || $this->available_profit <= 0;
    }

    public function getTotalProfitAttribute()
    {
        if ($this->plan && $this->plan->interest_rate) {
            return $this->amount_invested * ($this->plan->interest_rate / 100);
        }
        return 0;
    }

    public function isWithdrawn()
    {
        return $this->status === self::STATUS_WITHDRAWN || $this->status === self::STATUS_COMPLETED;
    }
public function getCanWithdrawNowAttribute()
{
    return $this->status === 'completed' && is_null($this->withdrawn_at);
}

    
}
