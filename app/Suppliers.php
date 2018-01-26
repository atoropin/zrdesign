<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = 'suppliers';

    public function manufacturer()
    {
        return $this->hasMany('App\Product', 'manufacturer_id');
    }
}
