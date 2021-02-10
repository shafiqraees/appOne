<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddImpresssion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeSearch($query,$max, $min)
    {
        if (!empty($max)) {
            return $query
                ->whereBetween('created_at', [$min,$max]);
        } else{
            return $query;
        }

    }
}
