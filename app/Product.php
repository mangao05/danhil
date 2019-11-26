<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function cart(){
        return $this->hasMany(AddToCart::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetails::class);
    }

    public function packageDetails(){
        return $this->hasMany(Package_Details::class, 'package_id', 'id');
    }

    public function productPackage(){
        return $this->hasMany(Package_Details::class, 'product_id', 'id');
    }
    
    public function category(){
        return $this->belongsTo(Category::class, 'id', 'category_id');
    }

    public function orderPackageDetails(){
        return $this->hasMany(OrderPackageDetails::class, 'package_id', 'id');
    }
}
