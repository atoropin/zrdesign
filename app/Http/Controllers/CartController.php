<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $minusPrice = $item->product->base_price * env('DOLLAR', '62');;

        return response()->json([
            'minusPrice' => $minusPrice
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
        $products = Cart::where('session_hash', $this->sessionHash)->get();

        dd($products);

        //clear cart!!!

        $this->validate($request, [ 'name' => 'required', 'email' => 'required|email', 'message' => 'required' ]);

        Mail::send('email',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message)
            {
                $message->from('no-reply@zrdesign.ru');
                $message->to('admin@zrdesign.ru', 'Admin')->subject('New Order');
            });

        return back()->with('success', 'Thanks for contacting us!');
    }
}
