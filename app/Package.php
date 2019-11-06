<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    public function package_details(){
        return $this->hasMany(Package_Details::class);
    }
}
