<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $guarded = [];

    // relationship with user categories
    public function userCategories() {
        return $this->belongsToMany(Category::class, 'user_profile_categories');
    }
    // get user yopics
    public function topics() {
        return $this->belongsToMany(Topic::class, 'user_topics');
    }

    public function usersInterests() {
        return $this->hasMany(UserProfileCategory::class);
    }
    public function packages() {
        return $this->belongsToMany(Package::class, 'marketer_packages');
    }
    // get user yopics
   /* public function followers() {
        return $this->hasMany(Follower::class,'follow_to_id');
    }
    // where current user follow some one profile
    public function followings(){
        return $this->hasMany(Follower::class, 'follow_by_id');
    }*/

    // where current user follow some one profile
    public function posts(){
        return $this->hasMany(Post::class);
    }

// users that are followed by this user
    public function following() {
        return $this->belongsToMany(UserProfile::class, 'followers', 'follow_by_id', 'follow_to_id');
    }

// users that follow this user
    public function followers() {
        return $this->belongsToMany(UserProfile::class, 'followers', 'follow_to_id', 'follow_by_id');
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function city() {
        return $this->belongsTo(City::class);
    }
    public function country() {
        return $this->belongsTo(Country::class);
    }
// get adds Impressions
    public function addImpressions() {
        return $this->hasMany(AddImpresssion::class);
    }

    // get post comments
    public function postcomment() {
        return $this->hasManyThrough(PostComment::class, Post::class);
    }
    // get post activities
    public function postlike() {
        return $this->hasManyThrough(PostActivity::class, Post::class);
    }
    // get post Images and videos
    public function postfile() {
        return $this->hasManyThrough(PostImage::class, Post::class);
    }

    // users that follow this user
    public function requestedByProfile() {
        return $this->belongsToMany(UserProfile::class, 'private_profiles', 'private_profile', 'requested_profile');
    }
}
