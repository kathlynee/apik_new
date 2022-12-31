<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Citie;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;
use App\Models\Courier;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CartController extends Controller
{
    public function index(){
        $cart = Cart::where('customer_id', Auth::guard('costumer')->user()->id)->get();


        $subtotal = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_price'];
        });
        $weight = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_weight'];
        });

        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::orderBy('created_at', 'DESC')->get();

        return view('costumer.cart', compact('cart', 'subtotal', 'weight', 'couriers', 'provinces'));
    }

    public function checkout(){
        $cart = Cart::where('customer_id', Auth::guard('costumer')->user()->id)->get();

        $subtotal = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_price'];
        });
        $weight = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_weight'];
        });

        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::orderBy('created_at', 'DESC')->get();

        foreach ($cart as $row) {
            $cost = RajaOngkir::ongkosKirim([
                'origin'       => 444,
                'destination'  => $row->customer->city_id,
                'weight'       => $weight,
                'courier'      => 'jne',
            ])->get();
        }


        return view('costumer.checkout', compact('cart', 'subtotal', 'weight', 'couriers', 'provinces', 'cost'));
    }

    public function coba(){
        $cart = Cart::where('customer_id', Auth::guard('costumer')->user()->id)->get();

        $subtotal = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_price'];
        });
        $weight = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_weight'];
        });

        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::orderBy('created_at', 'DESC')->get();


        return view('costumer.order', compact('cart', 'subtotal', 'weight', 'couriers', 'provinces'));
    }


    public function getCity($id)
    {
        $cities = Citie::where('province_id', $id)->pluck('name', 'id');
        response()->json($cities);
    }

    public function addToCart(Request $request){
        $this->validate($request,[
            'customer_id' => ['required'],
            'product_id' => ['required'],
            'cart_price' => ['required'],
            'cart_weight' => ['required'],
            'qty' => ['required'],
        ]);

        $data = new Cart();
        $data->customer_id = $request->customer_id;
        $data->product_id = $request->product_id;
        $data->cart_price = $request->cart_price;
        $data->cart_weight = $request->cart_weight;
        $data->qty = $request->qty;
        $data->save();

        return back()->with('alert-success','Kamu berhasil Register');
    }

    public function destroy($id){
        $cart = Cart::find($id);
        $cart->delete();

        return back()->with('alert-success','Kamu berhasil Register');
    }

    public function updateCart(Cart $cart){
        $cart->update([
            'qty' => request('qty')
        ]);

        return back();
    }

}
