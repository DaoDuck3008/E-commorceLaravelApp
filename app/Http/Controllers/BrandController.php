<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Models\Category;


class BrandController extends Controller
{
    //
    public function index (){
        $brands = Brand::with('categories')->get();

        return view('brand.index', ['brands' => $brands]);
    }

    public function create(){
        $categories = Category::all();

        return view('brand.create',['categories' => $categories]);
    }

    public function store(Request $request){
        //validate
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'categoryID' => 'required',
        ]);

        DB::beginTransaction();

        try{
            Brand::create([
                'BrandName' => $request->name,
                'Description' => $request->description,
                'CategoryID' => $request->categoryID,
            ]);

            DB::commit();

            return redirect('/admin/brand')->with('success','Danh mục đã được thêm thành công!');
        }catch (\Exception $e){
            DB::rollBack();

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi xảy ra khi tạo danh mục: ' . $e->getMessage());
        }
    }

    public function edit($id){
        try{
            $brand = Brand::findOrFail($id);
            $categories = Category::all();

            return view('brand.edit',['brand' => $brand,'categories' => $categories]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Mở chỉnh sửa thương hiệu không thành công! '. $e->getMessage());
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'categoryID' => 'required'
        ]);

        DB::beginTransaction();

        try{
            $brand = Brand::findOrFail($id);
            $brand->update([
                'BrandName' => $request->name,
                'Description' => $request->description,
                'CategoryID' => $request->categoryID
            ]);

            DB::commit();

            return redirect()->route('brand.index')->with('success', 'Cập nhật thương hiệu thành công!');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Cập nhật thương hiệu không thành công! '. $e->getMessage());
        }
    }

    public function destroy($id){
        DB::beginTransaction();

        try{
            Brand::destroy($id);

            DB::commit();

            return redirect()->route('brand.index')->with('success', 'Xóa thương hiệu thành công!');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect('brand.index')->with('error', 'Xóa thương hiệu không thành công! '. $e->getMessage());
        }
    }

    public function search(Request $request){
        $request->validate([
            'input' => 'nullable|string'
        ]);

        $keyword = $request->input;

        $brands = Brand::where('BrandName','like',"%{$request->input}%")
                        ->orWhere('Description','like',"%{$request->input}%")
                        ->orWhereHas('categories', function($query) use ($keyword){
                            $query->where('CategoryName', 'like',"%{$keyword}%");
                        })
                        ->get();

        return view('brand.index',['brands'=> $brands]);
    }

    public function getByCategory($id){
        $brands = Brand::where('CategoryID', $id)->get();

        return response()->json($brands);
    }

}
