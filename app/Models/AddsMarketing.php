<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddsMarketing extends Model
{
    use HasFactory;
    protected $guarded = [];

    // get adds Impressions
    public function addImpressions() {
        return $this->hasMany(AddImpresssion::class);
    }
    public function userProfile() {
        return $this->belongsTo(UserProfile::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    //post Activities
    public function addActivities() {
        return $this->hasMany(AddActivity::class);
    }

    public function hashtag() {
        return $this->belongsToMany(HashTag::class,'add_hash_tags');
    }

    public function scopeSearch($query, $keywords)
    {
        return $query
            ->where('id', 'like', "%" . $keywords . "%")
            ->orWhere('name', 'like', "%" . $keywords . "%")
            ->orWhere('add_number', 'like', "%" . $keywords . "%")
            ->orWhere('funds_to', 'like', "%" . $keywords . "%")
            ->orWhere('status', 'like', "%" . $keywords . "%")
            ->orWhereHas('user', function ($query) use($keywords){
                $query->where('name', 'LIKE', '%' . $keywords . '%');
            })
            ->whereNull("deleted_at");
    }

    public function scopeDateFilter($query, $date)
    {
        if (!empty($date)) {
            return $query
                ->whereDate('created_at', $date)
                ->whereNull("deleted_at");
        } else{
            return $query;
        }

    }
}
