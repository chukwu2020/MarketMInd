<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;
protected $guarded = [];
    public function user() {
    return $this->belongsTo(User::class);
}

// In Withdrawal.php
public function investment()
{
    return $this->belongsTo(Investment::class);
}

protected $casts = [
    'wallet_choice' => 'string',
];


}
