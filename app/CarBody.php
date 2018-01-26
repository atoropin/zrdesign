<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBody extends Model
{
    protected $table = 'car_bodies';

    public function model()
    {
        return $this->belongsTo('App\CarModel', 'car_model_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
