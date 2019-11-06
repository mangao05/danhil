<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddToCart extends Model
{
    protected $table = "addtocart";
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
