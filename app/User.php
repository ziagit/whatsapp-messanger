<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use  Notifiable;

    //related to guard starting functions
    public function getAuthIdentifierName()
    {
        return 'name';
    }
    public function getAuthIdentifier()
    {
        return $this->name;
    }
    public function getAuthPassword()
    {
        return null;
    }
    public function getRememberToken()
    {
        return null;
    }
    public function setRememberToken($value)
    {
    }
    public function getRememberTokenName()
    {
    }
    //end of guard




/*     public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    } */

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
