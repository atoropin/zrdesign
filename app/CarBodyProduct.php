<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBodyProduct extends Model
{
    protected $table = 'car_bodies_products';

    public function bodies()
    {
        return $this->belongsTo('App\CarBody', 'car_body_id');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'product_id');
    }
}
