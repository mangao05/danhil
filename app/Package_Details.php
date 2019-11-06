<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package_Details extends Model
{
    protected $guarded = [];

    public function package(){
        return $this->belongsTo(Product::class, 'package_id', 'id');
    }
    
    public function products(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
