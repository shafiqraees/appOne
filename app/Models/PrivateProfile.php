<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateProfile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function requestedBy() {
        return $this->belongsTo(UserProfile::class,'requested_profile');
    }

    public function requestedTo() {
        return $this->belongsTo(UserProfile::class,'private_profile');
    }
}
