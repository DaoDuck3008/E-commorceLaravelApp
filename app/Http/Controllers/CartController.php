<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function index(){
        return view('cart.index');
    }

    public function addItem(Request $request){
        // dd($request->productID);
        //kiểm tra xem người dùng đã to
        $cart = Cart::where('UserID', $request->userID)->first() ?? Cart::create(['UserID' => $request->userID]);
    }
}
