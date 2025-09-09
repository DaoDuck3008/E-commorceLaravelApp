<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Food;

// class FoodsController extends Controller
// {
//     public function index (){
//         $foods = Food::all();
//         // dd($foods);
//         return view('foods.index',['foods' => $foods]);
//     }

//     public function create() {
//         return view('foods.create');
//     }

//     public function store(Request $request){
//         // dd('This is store function');
//         $food = new Food();
//         $food->food_name = $request->input("food_name");
//         $food->count = $request->input('count');
//         $food->description = $request->input('description');

//         $food->save();
//         return redirect('/foods');
//     }

//     public function edit($id){
//         $food = Food::find($id);
//         return view('foods.edit')->with('food', $food);
//     }

//     public function update(Request $request, $id){
//         $food = Food::where('id', $id)
//                     ->update([
//                         'food_name' => $request->input('food_name'),
//                         'count' => $request->input('count'),
//                         'description' => $request->input('description'),
//                         'updated_at' => now()
//                     ]);
//         return redirect()->route('foods.index');
//     }

//     public function destroy($id){
//         $food = Food::where('id', $id);
//         $food->delete();

//         return redirect('/foods');
//     }

//     public function show($id){
//         $food = Food::find($id);
//         $category = Category::find($food->id);
//         $food->category = $category;

//         // dd($category);
//         return view('foods.detail',['food' => $food]);
//     }
// }
 