<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\CarBody;
use App\CarBrand;
use App\ProductGroup;
use App\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    private $cartCount;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->cartCount = Cart::where('session_hash', $this->sessionHash)->count();
    }

    public function index()
    {
        if (Session::has('success')) {
            Session::flash('success', 'Ваш заказ поступил в обработку!');
        }

        $productsCarousel = Product::with(['group', 'manufacturer', 'pictures'])
            ->inRandomOrder()
            ->take(10)
            ->get();

        $groups = ProductGroup::orderBy('name', 'asc')->get();

        $manufacturers = Suppliers::whereNotNull('type')
            ->with('currency')
            ->orderBy('name', 'asc')
            ->get();

        $allManufacturers = $manufacturers;

        $brandData = $this->getCarBrandData();

        $parameters = [];

        $cartCount = $this->cartCount;

        $carBodyInfo = null;

        return view('index',
            compact(
                'productsCarousel',
                'groups',
                'allManufacturers',
                'manufacturers',
                'brandData',
                'parameters',
                'cartCount',
                'carBodyInfo'
            )
        );
    }

    public function products(Request $request)
    {
        $parameters = $request->input();

        $page = $request->input('page') ?: 1;

        $carBodyInfo = null;

        if($request->input('body') == null) {
            $ProductsCollection = $this->getProducts($parameters);
        } else {
            $ProductsCollection = $this->getBodyProducts($parameters);
            $bodyName = $ProductsCollection['bodyName'];
            $carBodyInfo = $ProductsCollection['carBodyInfo'];
        }

        $brandData = $this->getCarBrandData();

        $allManufacturers = Suppliers::whereNotNull('type')
            ->orderBy('name', 'asc')
            ->get();

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

        $products = $products->sortBy('id')->forPage($page, $perPage);

        $cartCount = $this->cartCount;

        unset($parameters['page']);

        return view('index',
            compact(
                'brandData',
                'products',
                'groups',
                'allManufacturers',
                'manufacturers',
                'parameters',
                'next',
                'prev',
                'totalItems',
                'bodyName',
                'cartCount',
                'carBodyInfo'
            )
        );
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
            ->orderBy('id')
            ->get();

        $groups = ProductGroup::orderBy('name', 'asc')->get();

        $manufacturers = Suppliers::whereNotNull('type')
            ->with('currency')
            ->orderBy('name', 'asc')
            ->get();

        $ProductsCollection = collect([
            'products' => $products,
            'groups' => $groups,
            'manufacturers' => $manufacturers
        ]);

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
                $groups = $query->orderBy('name', 'asc')
                    ->get()
                    ->unique();
            },
            'products.manufacturer' => function($query) use (&$manufacturers) {
                $manufacturers = $query->orderBy('name', 'asc')
                    ->with('currency')
                    ->get()
                    ->unique();
            }])->findOrFail($bodyId);

        $products = Product::with('pictures')
            ->whereHas('bodies', function($query) use($bodyId) {
                $query->where('id', $bodyId);
            })
            ->when($manufacturerId, function($query) use($manufacturerId) {
                $query->where('manufacturer_id', $manufacturerId);
            })
            ->when($groupId, function($query) use($groupId) {
                $query->where('product_group_id', $groupId);
            })
            ->orderBy('id')
            ->get();

        $carBodyInfo = collect([
            'id' => $carBody->id,
            'brand_id' => $carBody->model->brand->id,
            'model_id' => $carBody->model->id,
            'body_id' => $carBody->id
        ]);

        $ProductsCollection = collect([
            'products' => $products,
            'groups' => $groups,
            'manufacturers' => $manufacturers,
            'carBody' => $carBody,
            'bodyName' => $carBody->name,
            'carBodyInfo' => $carBodyInfo
        ]);

        return $ProductsCollection;
    }

//    public function _getBodyProducts($parameters)
//    {
//        $manufacturerId = Arr::exists($parameters, 'manufacturer') ? $parameters['manufacturer'] : null;
//        $groupId = Arr::exists($parameters, 'group') ? $parameters['group'] : null;
//        $bodyId = Arr::exists($parameters, 'body') ? $parameters['body'] : null;
//
//        $carBody = CarBody::with([
//                'model.brand',
//                'products.group' => function($query) use (&$groups) {
//                    $groups = $query->orderBy('name', 'asc')->get()->unique();
//                },
//                'products.manufacturer' => function($query) use (&$manufacturers) {
//                    $manufacturers = $query->orderBy('name', 'asc')->with('currency')->get()->unique();
//                },
//                'products.pictures' => function($query) use (&$pictures) {
//                    $pictures = $query->get();
//                },
//                'products' => function($query) use ($manufacturerId, $groupId) {
//                    $manufacturerId ? $query->where('manufacturer_id', $manufacturerId)->get() : null;
//                    $groupId ? $query->where('product_group_id', $groupId)->get() : null;
//                }
//            ])
//            ->findOrFail($bodyId);
//
//        $products = $carBody->products;
//        $bodyName = $carBody->name;
//
//        $products->groups = $groups;
//        $products->manufacturers = $manufacturers;
//        $products->pictures = $pictures;
//
//        $carBodyInfo = collect(['id' => $carBody->id, 'brand_id' => $carBody->model->brand->id, 'model_id' => $carBody->model->id, 'body_id' => $carBody->id]);
//
//        $ProductsCollection = collect(['products' => $products, 'groups' => $groups, 'manufacturers' => $manufacturers, 'carBody' => $carBody, 'bodyName' => $bodyName, 'carBodyInfo' => $carBodyInfo]);
//
//        return $ProductsCollection;
//    }

    public function getCarBrandData()
    {
        return CarBrand::with('models.bodies')
            ->orderBy('name', 'asc')
            ->get();
    }
}
