<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function profiles() {
        return $this->belongsTo(UserProfile::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
