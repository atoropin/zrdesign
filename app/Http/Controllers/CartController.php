<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOrder;

class CartController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function addToCart($productId)
    {
        $cart = new Cart();
        $cart->session_hash = $this->sessionHash;
        $cart->product_id = $productId;
        $cart->save();

        $itemsCount = Cart::where('session_hash', $this->sessionHash)->count();

        return response()->json([
            'itemsCount' => $itemsCount
        ]);
    }

    public function deleteFromCart($itemId)
    {
        $item = Cart::where('session_hash', $this->sessionHash)->where('id', $itemId)->firstOrFail();
        $item->delete();

        $uCart = Cart::where('session_hash', $this->sessionHash)->with('product.manufacturer', 'product.pictures')->get();
        $totalPrice = 0;
        foreach ($uCart as $item) {
            $totalPrice += $item->product->base_price;
        }
        $totalPrice *= env('DOLLAR', '62');

        return response()->json([
            'totalPrice' => $totalPrice
        ]);
    }

    public function viewCart()
    {
        $uCart = Cart::where('session_hash', $this->sessionHash)->with('product.manufacturer', 'product.pictures')->get();

        $totalPrice = 0;
        foreach ($uCart as $item) {
            $totalPrice += $item->product->base_price;
        }
        $totalPrice *= env('DOLLAR', '62');

        return view('cart')->with(compact('uCart', 'totalPrice'));
    }

    public function sendOrder(Request $request)
    {
        $cart = Cart::where('session_hash', $this->sessionHash)->get();

        $productsIds = [];
        foreach ($cart as $item) {
            $productsIds[] = $item->product_id;
        }

        $products = Product::with('manufacturer')->whereIn('id', $productsIds)->get()->keyBy('id')->toArray();
        $cartItems = [];
        foreach ($productsIds as $productsId) {
            $cartItems[] = $products[$productsId];
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item->product->base_price;
        }
        $totalPrice *= env('DOLLAR', '62');

//        $this->validate($request, ['email' => 'required|email']);

        $order = new \stdClass();
        $order->date = date('d.m.Y H:i');
        $order->items = $cartItems;
        $order->name = $request->get('name');
        $order->phone = $request->get('phone');
        $order->email = $request->get('email');
        $order->message = $request->get('message');
        $order->total = $totalPrice;

        try {
            Mail::to("order@zrdesign.ru")->send(new SendOrder($order));
        } catch (\Exception $exception) {
            abort(404);
        }

        // Clearing cart after sending message
        foreach ($cart as $item) {
            $item->delete();
        }

        return redirect('/');
    }
}
