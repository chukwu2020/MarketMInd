<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdVerification  extends Model
{
    use HasFactory;
     protected $guarded = [];
 protected $table = 'id_verifications';
     public function user()
{
    return $this->belongsTo(User::class);
}

}
