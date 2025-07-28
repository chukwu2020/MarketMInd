<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User; // Import User model
class IdVerification extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $table = 'id_verifications';

    // This defines the relation to User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
