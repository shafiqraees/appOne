<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
//use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Passport\Passport;
//use Laravel\Passport\HasApiTokens;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    //use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    public function profiles(){
        return $this->hasMany(UserProfile::class);
    }
    public function trasanction(){
        return $this->hasMany(UserTransaction::class);
    }
    public function city() {
        return $this->belongsTo(City::class);
    }
    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function packages() {
        return $this->belongsToMany(Package::class, 'marketer_packages');
    }
    public function addImpression() {
        return $this->hasManyThrough(AddImpresssion::class, AddsMarketing::class);
    }

    public function scopeSearch($query, $keywords)
    {
        return $query
            ->where('id', 'like', "%" . $keywords . "%")
            ->orWhere('name', 'like', "%" . $keywords . "%")
            ->orWhere('email', 'like', "%" . $keywords . "%")
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
