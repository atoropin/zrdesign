<?php

namespace App\Http\Controllers;

use App\CarBody;
use App\CarBrand;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function index()
    {
        $brands = CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();

        return view('index')->with(compact('brands'));
    }

    public function body($id)
    {

        DB::connection()->enableQueryLog();

        $body = CarBody::with('model')->findOrFail($id);

        dd(DB::getQueryLog());

        return view('body')->with(compact('body'));
    }
}
