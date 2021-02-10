<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    protected $guarded = [];

    //user profile
    public function userProfile() {
        return $this->belongsTo(UserProfile::class);
    }
    // comments likes
    public function commentLikes() {
        return $this->hasMany(PostCommentsLike::class);
    }
}
