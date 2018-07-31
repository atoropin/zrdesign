<?php

namespace App\Http\Controllers;

use App\Product;
use App\CarBody;
use App\CarBrand;
use App\ProductGroup;
use App\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    public function index()
    {
        $productsCarousel = Product::with(['group', 'manufacturer', 'pictures'])->inRandomOrder()->take(3)->get();

        $groups = ProductGroup::orderBy('name', 'asc')->get();

        $manufacturers = Suppliers::whereNotNull('type')->get();

        $brandData = $this->getCarBrandData();

        $parameters = [];

        return view('index', compact('productsCarousel', 'groups', 'manufacturers', 'brandData', 'parameters'));
    }

    public function products(Request $request)
    {
        $parameters = $request->input();

        $page = $request->input('page') ?: 1;

        if($request->input('body') == null) {
            $ProductsCollection = $this->getProducts($parameters);
        } else {
            $ProductsCollection = $this->getBodyProducts($parameters);
//            $carBodyInfo = $ProductsCollection['carBodyInfo'];
        }

        $brandData = $this->getCarBrandData();

        $groups = $ProductsCollection['groups'];
        $manufacturers = $ProductsCollection['manufacturers'];
        $products = $ProductsCollection['products'];

        $perPage = 15;
        $totalItems = $products->count();
        $lastPage = ceil($totalItems / $perPage); // Total Pages

        $next = null;
        $prev = null;

        if(!$page || $page == 1) {
            $prev = null;
        } else {
            $prev = $page - 1;
        }
        if($page == $lastPage) {
            $next = null;
        } else {
            $next = $page + 1;
        }

        $products = $products->forPage($page, $perPage);

        return view('index', compact('brandData', 'products', 'groups', 'manufacturers', 'parameters', 'next', 'prev', 'totalItems'));
    }

    public function getProducts($parameters)
    {
        $manufacturerId = Arr::exists($parameters, 'manufacturer') ? $parameters['manufacturer'] : null;
        $groupId = Arr::exists($parameters, 'group') ? $parameters['group'] : null;

        $products = Product::with('pictures')
            ->when($manufacturerId, function($query) use($manufacturerId) {
                $query->where('manufacturer_id', $manufacturerId);
            })
            ->when($groupId, function($query) use($groupId) {
                $query->where('product_group_id', $groupId);
            })
            ->get();

        $groups = ProductGroup::orderBy('name', 'asc')->get();

        $manufacturers = Suppliers::whereNotNull('type')->get();

        $ProductsCollection = collect(['products' => $products, 'groups' => $groups, 'manufacturers' => $manufacturers]);

        return $ProductsCollection;
    }

    public function getBodyProducts($parameters)
    {
        $manufacturerId = Arr::exists($parameters, 'manufacturer') ? $parameters['manufacturer'] : null;
        $groupId = Arr::exists($parameters, 'group') ? $parameters['group'] : null;
        $bodyId = Arr::exists($parameters, 'body') ? $parameters['body'] : null;

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
                },
                'products' => function($query) use ($manufacturerId, $groupId) {
                    $manufacturerId ? $query->where('manufacturer_id', $manufacturerId)->get() : null;
                    $groupId ? $query->where('product_group_id', $groupId)->get() : null;
                }
            ])
            ->findOrFail($bodyId);

        $products = $carBody->products;

        $products->groups = $groups;
        $products->manufacturers = $manufacturers;
        $products->pictures = $pictures;

//        $carBodyInfo = collect(['id' => $carBody->id, 'brand' => $carBody->model->brand->name, 'model' => $carBody->model->name, 'name' => $carBody->name]);

        $ProductsCollection = collect(['products' => $products, 'groups' => $groups, 'manufacturers' => $manufacturers, 'carBody' => $carBody]);

        return $ProductsCollection;
    }

    public function getCarBrandData()
    {
        return CarBrand::with('models.bodies')->orderBy('name', 'asc')->get();
    }
}
