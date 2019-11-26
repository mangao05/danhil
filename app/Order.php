<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'order_details' => 'array'
    ];

    public function orderDetails(){
        return $this->hasMany(OrderDetails::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function collection(){
        return $this->hasMany(Collection::class);
    }

}
