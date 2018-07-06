<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;

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
    }

    public function deleteFromCart($itemId)
    {
        $item = Cart::where('session_hash', $this->sessionHash)->where('id', $itemId)->firstOrFail();
        $item->delete();

        return redirect('cart/view');
    }

    public function viewCart()
    {
        $total = 0;

        $uCart = Cart::where('session_hash', $this->sessionHash)->with('product.manufacturer')->get();

        return view('cart')->with(compact('uCart', 'total'));
    }

    public function sendOrder()
    {
        //clear cart!!!
    }
}
