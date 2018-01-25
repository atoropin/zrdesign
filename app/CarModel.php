<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models';

    public function brand()
    {
        return $this->belongsTo('App\CarBrand');
    }

    public function bodies()
    {
        return $this->hasMany('App\CarBody');
    }
}
