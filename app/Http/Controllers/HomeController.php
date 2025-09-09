<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    //
    public function index (){
        $products = Product::all();
        $categories = Category::orderBy('Priority', 'asc')->get();

        return view('product.index',['products' => $products,'categories' => $categories]);
    }
}
