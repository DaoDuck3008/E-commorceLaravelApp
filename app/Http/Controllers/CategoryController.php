<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    //
    public function index (){
        $categories = Category::all();

        return view('category.index', ['categories' => $categories]);
    }

    public function create(){
        return view('category.create');
    }

    public function store(Request $request){
        //validate
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'icon' =>  'nullable|string',
        ]);

        DB::beginTransaction();

        try{
            Category::create([
                'CategoryName' => $request->name,
                'Description' => $request->description,
                'Icon' => $request->icon
            ]);

            DB::commit();

            return redirect('/admin/category')->with('success','Danh mục đã được thêm thành công!');
        }catch (\Exception $e){
            DB::rollBack();

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi xảy ra khi tạo danh mục: ' . $e->getMessage());
        }
    }

    public function edit($id){
        try{
            $category = Category::findOrFail($id);

            return view('category.edit',['category' => $category]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Mở chỉnh sửa danh mục không thành công! '. $e->getMessage());
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'icon' =>  'nullable|string',
        ]);

        DB::beginTransaction();

        try{
            $category = Category::findOrFail($id);
            $category->update([
                'CategoryName' => $request->name,
                'Description' => $request->description,
                'Icon' => $request->icon
            ]);

            DB::commit();

            return redirect()->route('category.index')->with('success', 'Cập nhật danh mục thành công!');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Cập nhật danh mục không thành công! '. $e->getMessage());
        }
    }

    public function destroy($id){
        DB::beginTransaction();

        try{
            Category::destroy($id);

            DB::commit();

            return redirect()->route('category.index')->with('success', 'Xóa danh mục thành công!');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect('category.index')->with('error', 'Xóa danh mục không thành công! '. $e->getMessage());
        }
    }

    public function getAllCategories(){
        $categories = Category::all();

        return response()->json($categories);
    }

}
