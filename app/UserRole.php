<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_role';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
