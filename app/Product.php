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
}
