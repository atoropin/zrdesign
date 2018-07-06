<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    protected $table = 'product_pictures';

    public function picture()
    {
        return $this->belongsTo('App\Product');
    }
}
