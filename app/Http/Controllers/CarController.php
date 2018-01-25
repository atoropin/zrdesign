<?php

namespace App\Http\Controllers;

use App\CarBrand;
use App\CarModel;

class CarController extends Controller
{
    public function index()
    {
        $carBrands = CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();

        return view('index')->with(compact('carBrands'));
    }

    public function carBrand($id)
    {
        return $brandModels = CarModel::where('car_brand_id', $id)->get();
    }
}
