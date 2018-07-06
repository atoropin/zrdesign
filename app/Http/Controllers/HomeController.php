<?php

namespace App\Http\Controllers;

use App\Product;
use App\CarBody;
use App\CarBrand;
use App\ProductGroup;
use App\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class HomeController extends Controller
{
    public function index()
    {
        $productsCarousel = Product::with(['group', 'manufacturer', 'pictures'])->inRandomOrder()->take(3)->get();

        $groups = ProductGroup::orderBy('name', 'asc')->get();

        $manufacturers = Suppliers::whereNotNull('type')->get();

        $brandData = $this->getCarBrandData();

//        dd($brandData);

        $parameters = [];

        return view('index', compact('productsCarousel', 'groups', 'manufacturers', 'brandData', 'parameters'));
    }

    public function products(Request $request)
    {
        $parameters = $request->input();

        if($request->input('body') == null) {
            $ProductsCollection = $this->getProducts($parameters);
        } else {
            $ProductsCollection = $this->getBodyProducts($parameters);
//            $carBodyInfo = $ProductsCollection['carBodyInfo'];
        }

        $brandData = $this->getCarBrandData();

//        dd($brandData);

        $groups = $ProductsCollection['groups'];
        $manufacturers = $ProductsCollection['manufacturers'];
        $products = $ProductsCollection['products'];

        return view('index', compact('brandData', 'products', 'groups', 'manufacturers', 'parameters'));
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

    public function getImage($id, $size, $name)
    {
        $imagePath = 'production/product_pictures/'.$id.'/'.$size.'/'.$name;

        $image = Storage::disk('s3')->get($imagePath);

        if ($image) {
            return Image::make($image)->response('jpg');
        } else
            return 'No Image';
    }

//    public function getProducts(Request $request)
//    {
//        $parameters = $request->input();
//
//        $manufacturerId = $request->manufacturer;
//        $groupId = $request->group;
//
//        $productsFiltered = Product::with('pictures')
//            ->when($manufacturerId, function($query) use($manufacturerId) {
//                $query->where('manufacturer_id', $manufacturerId);
//            })
//            ->when($groupId, function($query) use($groupId) {
//                $query->where('product_group_id', $groupId);
//            })
//            ->get();
//
//        $groups = ProductGroup::orderBy('name', 'asc')->get();
//
//        $manufacturers = Suppliers::whereNotNull('type')->get();
//
//        return view('index', compact('productsFiltered', 'groups', 'manufacturers', 'parameters'));
//    }

//    public function getBodyProducts(Request $request)
//    {
//        $parameters = $request->input();
//
//        $manufacturerId = $request->manufacturer;
//        $groupId = $request->group;
//        $bodyId = $request->body;
//
//        $products = CarBody::with([
//                'model.brand',
//                'products.group' => function($query) use (&$groups) {
//                    $groups = $query->orderBy('name', 'asc')->get()->unique();
//                },
//                'products.manufacturer' => function($query) use (&$manufacturers) {
//                    $manufacturers = $query->orderBy('name', 'asc')->get()->unique();
//                },
//                'products.pictures' => function($query) use (&$pictures) {
//                    $pictures = $query->get();
//                }
//            ])
//            ->findOrFail($bodyId);
//
//        $productsFiltered = CarBody::with([
//                'products' => function($query) use ($manufacturerId, $groupId) {
//                    $manufacturerId ? $query->where('manufacturer_id', $manufacturerId)->get() : null;
//                    $groupId ? $query->where('product_group_id', $groupId)->get() : null;
//                }
//            ])
//            ->findOrFail($bodyId);
//
//        $products->groups = $groups;
//        $products->manufacturers = $manufacturers;
//        $products->pictures = $pictures;
//
//
//        return view('body', compact('products', 'manufacturers', 'groups', 'parameters'));
//    }
}
