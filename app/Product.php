<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function group()
    {
        return $this->belongsTo('App\ProductGroup', 'product_group_id');
    }

    public function bodies()
    {
        return $this->belongsToMany('App\CarBody', 'car_bodies_products', 'product_id', 'car_body_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('App\Suppliers');
    }
}
