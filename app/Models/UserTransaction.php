<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function package() {
        return $this->belongsTo(Package::class);
    }

    public function scopeSearch($query, $keywords)
    {
        return $query
            ->where('id', 'like', "%" . $keywords . "%")
            ->orWhere('transaction_id', 'like', "%" . $keywords . "%")
            ->orWhere('fee', 'like', "%" . $keywords . "%")
            ->orWhere('amount', 'like', "%" . $keywords . "%")
            ->orWhere('package_name', 'like', "%" . $keywords . "%")
            ->orWhereHas('user', function ($query) use($keywords){
                $query->where('name', 'LIKE', '%' . $keywords . '%');
            })
            ->whereNull("deleted_at");
    }

    public function scopeCreditLog($query, $keywords)
    {
        return $query
            ->where('id', 'like', "%" . $keywords . "%")
            ->orWhere('fee', 'like', "%" . $keywords . "%")
            ->orWhere('amount', 'like', "%" . $keywords . "%")
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
    public function scopeIncome($query,$max, $min)
    {
        if (!empty($max)) {
            return $query
                ->whereBetween('created_at', [$min,$max]);
        } else{
            return $query;
        }

    }
}
