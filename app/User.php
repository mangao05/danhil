<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','lastname','firstname'
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

    public function user_details(){
        return $this->hasOne(UserDetails::class);
    }

    public function user_role(){
        return $this->hasMany(UserRole::class);
    }

    public function setRole($role){
        if(is_integer($role)){
            return $this->user_role->contains('role_id', $role);
        }
    }

    public function order(){
        return $this->hasMany(Order::class);
    }
}
