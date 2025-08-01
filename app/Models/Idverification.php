<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class IdVerification extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'id_verifications';

    // Define the inverse of the hasOne relationship in User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}