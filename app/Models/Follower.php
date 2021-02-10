<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function folowBY() {
        return $this->belongsTo(UserProfile::class,'follow_to_id');
    }

    public function folowTo() {
        return $this->belongsTo(UserProfile::class,'follow_by_id');
    }
}
