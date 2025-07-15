<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;


    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }


    /**
     * Relationship with Wallet
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }


    // In your Deposit model

}
