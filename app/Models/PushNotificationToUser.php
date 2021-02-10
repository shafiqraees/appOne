<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotificationToUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pushNotification() {
        return $this->belongsTo(PushNotification::class);
    }
}
