<?php

namespace App\Http\Controllers;

use App\CarBody;
use App\CarBrand;
use App\Cart;
use Illuminate\Http\Request;

class CarController extends Controller
{
    const DOLLAR = 58;

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index()
    {
        $carBrands = CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();

        return view('index')->with(compact('carBrands'));
    }

    public function carBody(Request $request, $bodyId)
    {
        $manufacturerId = $request->input('manufacturer');
        $groupId = $request->input('group');

        $carBody = CarBody::with([
            'model.brand',
            'products.group' => function($query) use (&$groups) {
                $groups = $query->orderBy('name', 'asc')->get()->unique();
            },
            'products.manufacturer' => function($query) use (&$manufacturers) {
                $manufacturers = $query->orderBy('name', 'asc')->get()->unique();
            },
            'products.pictures' => function($query) use (&$pictures) {
                $pictures = $query->get();
            }
            ])
            ->findOrFail($bodyId);

        $carBodyFiltered = CarBody::with([
            'products' => function($query) use ($manufacturerId, $groupId) {
                $manufacturerId ? $query->where('manufacturer_id', $manufacturerId)->get() : null;
                $groupId ? $query->where('product_group_id', $groupId)->get() : null;
            }
            ])
            ->findOrFail($bodyId);

        $carBody->groups = $groups;
        $carBody->manufacturers = $manufacturers;
        $carBody->pictures = $pictures;

        $carBrands = CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();

        $uCartCount = Cart::where('session_hash', $this->sessionHash)->count();

        return view('body')->with(compact('carBrands', 'carBody', 'carBodyFiltered', 'uCartCount'));
    }
}
