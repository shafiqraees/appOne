<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsType extends Model
{
    use HasFactory;
    protected $guarded = [];
    // get cms type  images
    public function CmsTypeImages() {
        return $this->hasMany(AboutUsImage::class);
    }
}
