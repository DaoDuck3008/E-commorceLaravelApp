<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    //
    public function index (){
        $products = Product::paginate(20);

        return view('product.index',['products' => $products]);
    }

    public function getRandomProduct(){
        $randomProducts =Product::inRandomOrder()->limit(5)->get();

        return response()->json($randomProducts);
    }
}
