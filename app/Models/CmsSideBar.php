<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsSideBar extends Model
{
    use HasFactory;
    protected $guarded = [];

    // get cms type
    public function CmsTypes() {
        return $this->hasOne(CmsType::class);
    }
}
