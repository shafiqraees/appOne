<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function postImage() {
        return $this->hasMany(PostImage::class);
    }

    public function postCategories() {
        return $this->belongsToMany(Category::class,'post_categories');
    }

    public function hashtag() {
        return $this->belongsToMany(HashTag::class,'post_hash_tags');
    }

    public function postTopics() {
        return $this->hasMany(PostTopic::class);
    }

    public function getpostTopic() {
        return $this->belongsToMany(Topic::class,'post_topics');
    }
    //post comments
    public function postComments() {
        return $this->hasMany(PostComment::class);
    }
    //post Activities
    public function postActivities() {
        return $this->hasMany(PostActivity::class);
    }
    public function likedby()
    {
        return $this->belongsToMany(UserProfile::class,'post_activities')
            ->withTimestamps();
    }
    public function userProfile() {
        return $this->belongsTo(UserProfile::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
