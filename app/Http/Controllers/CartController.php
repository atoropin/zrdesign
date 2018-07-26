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
    }

    public function deleteFromCart($itemId)
    {
        $item = Cart::where('session_hash', $this->sessionHash)->where('id', $itemId)->firstOrFail();
        $item->delete();

        return redirect('cart');
    }

    public function viewCart()
    {
        $total = 0;

        $uCart = Cart::where('session_hash', $this->sessionHash)->with('product.manufacturer')->get();

        return view('cart')->with(compact('uCart', 'total'));
    }

//    public function getFormData(Request $request)
//    {
//        $this->validate($request, [
//            'name' => 'required',
//            'email' => 'required|email'
//        ]);
//
//        $this->sendOrder();
//
//        return back()->with('success', 'Thanks for contacting us!');
//    }

    public function sendOrder(Request $request)
    {
        //clear cart!!!

        $this->validate($request, [ 'name' => 'required', 'email' => 'required|email', 'message' => 'required' ]);

        Mail::send('email',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message)
            {
                $message->from('saquib.gt@gmail.com');
                $message->to('saquib.rizwan@cloudways.com', 'Admin')->subject('Cloudways Feedback');
            });

        return back()->with('success', 'Thanks for contacting us!');
    }
}
