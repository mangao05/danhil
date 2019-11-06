<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function order(){
        return $this->hasMany(Role::class);
    }

    public function cart(){
        return $this->hasMany(AddToCart::class);
    }
}
