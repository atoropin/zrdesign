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
//        DB::connection()->enableQueryLog();

//        $carBody = CarBody::with('model.brand')->findOrFail($id);
//        $carBody = CarBody::with('groups')->findOrFail($id);

        $carBody = CarBody::with([
            'model.brand',
            'products.group' => function($query) use (&$groups) {
                $groups = $query->orderBy('name', 'asc')->get()->unique();
            },
            'products.manufacturer' => function($query) use (&$manufacturers) {
                $manufacturers = $query->orderBy('name', 'asc')->get()->unique();
            }])->findOrFail($id);

        $carBody->groups = $groups;
        $carBody->manufacturers = $manufacturers;

        $carBrands = CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();

        return view('body')->with(compact('carBrands', 'carBody'));
    }
}
