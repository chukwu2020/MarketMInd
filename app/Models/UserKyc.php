<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserKyc extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_document',
        'utility_bill',
        'status',
        'admin_note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
