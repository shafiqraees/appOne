<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function post() {
        return $this->belongsToMany(Post::class, 'post_topics');
    }

    public function scopeSearch($query, $keywords)
    {
        return $query
            ->where('id', 'like', "%" . $keywords . "%")
            ->orWhere('name', 'like', "%" . $keywords . "%")
            ->orWhere('status', 'like', "%" . $keywords . "%");
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
