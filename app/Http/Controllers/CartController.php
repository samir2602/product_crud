<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

class CartController extends Controller
{
    public function index()
    {
        Request()->request->add(['Pagetitle' => 'Cart', 'btntext' => 'Return to Home', 'btnclass' => 'btn btn-primary', 'btnurl' => route('home')]);
        $data['cart_data'] = Cart::where(['user_id' => auth()->user()->id])->with(['product_image', 'item_data'])->get()->toArray();
        return view('cart.index', $data);
    }

    public function add_to_cart($id)
    {
        $check_cart = Cart::where(['item' => $id, 'user_id' => auth()->user()->id])->first();      
        $product = Product::where(['id' => $id])->first();        
        $cart = [];
        
        if($check_cart) {
            $cart['quantity'] = $check_cart->quantity + 1;
            Cart::where(['item' => $id])->update($cart);
        } else {            
            $cart['item'] = $product->id;
            $cart['quantity'] = 1;
            $cart['price'] = $product->price;
            $cart['user_id'] = auth()->user()->id;
            $cart['user_email'] = auth()->user()->email;
            $cart['created_by'] = auth()->user()->id;
            Cart::create($cart);
        }
        return redirect()->to('home')->with('success', 'Product Added to cart');
    }

    public function chekcout()
    {
        Request()->request->add(['Pagetitle' => 'Checkout', 'btntext' => 'Return to Cart', 'btnclass' => 'btn btn-primary', 'btnurl' => route('cart.index')]);
        $data['cart_data'] = Cart::with(['product_image', 'item_data'])->get();
        return view('cart.checkout', $data);
    }

    public function order(Request $request)
    {
        $post = $request->all();
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'mobile_no' => 'required|numeric|digits_between:10,10',
            'address' => 'required',
            'payment' => 'required',
        ]);

        $order = Order::create($post);
        if($order){
            Cart::where(['user_id' => auth()->user()->id])->delete();            
        }
        return redirect()->to('home')->with('order_success', "Your Order Added Successfully");
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(['message' => 'Record deleted', 'status' => TRUE]);
    }
}
