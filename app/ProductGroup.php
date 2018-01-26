<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    protected $table = 'product_groups';

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
