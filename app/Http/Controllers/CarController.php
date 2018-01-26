<?php

namespace App\Http\Controllers;

use App\CarBody;
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
        DB::connection()->enableQueryLog();

//        $carBody = CarBody::with('model.brand', 'groups')->findOrFail($id);
        $carBody = CarBody::with('groups')->findOrFail($id);

        dd(DB::getQueryLog());

        $carBrands = CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();

//        $bodyProducts = Product::where('car_body_id', $id)->get();

        return view('body')->with(compact('carBrands', 'carBody'));
    }
}
