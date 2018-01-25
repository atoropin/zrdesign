<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBody extends Model
{
    protected $table = 'car_bodies';

    public function model()
    {
        return $this->belongsTo('App\CarModel');
    }
}