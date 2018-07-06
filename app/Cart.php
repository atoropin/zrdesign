<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = ['session_hash', 'product_id'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
