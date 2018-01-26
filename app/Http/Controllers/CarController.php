<?php

namespace App\Http\Controllers;

use App\CarBody;
use App\CarBodyProduct;
use App\CarBrand;
use App\Product;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function index()
    {
        $carBrands = CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();

        return view('index')->with(compact('carBrands'));
    }

    public function carBody($id)
    {
        $carBody = CarBody::with('model.brand')->findOrFail($id);

        $carBrands = CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();

        $bodyProducts = CarBodyProduct::with('groups')->where('car_body_id', $id)->get();

        return view('body')->with(compact('carBrands', 'carBody', 'bodyProducts'));
    }
}
