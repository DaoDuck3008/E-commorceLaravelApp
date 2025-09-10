<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\Productimg;
use App\Models\Productspecification;
use App\Models\Productversion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::all();

        return view('product.index',['products' => $products]);
    }

    public function dashboard(){
        $products = Product::with(['category','brand'])->get();
        $categories = Category::all();
        // dd($products);
        return view('product.dashboard', ['products' => $products, 'categories' => $categories]);
    }

    public function create(){
        $categories = Category::all();

        return view('product.create',['categories' => $categories]);
    }

    public function show($id){
        $product = Product::with(['productImgs', 'productSpecifications', 'productVersions', 'productColors','category','brand'])
                  ->find($id);

        // dd($product);          
        return view('product.detail', ['product' => $product]);
    }

    public function store (StoreProductRequest $request){
        //Validate ở trong file StoreProductRequest
        $request->validated();

        // dd($request);

        DB::beginTransaction();

        try{

            // Biến đổi ảnh đầu tiên thành URL trước
            $firtImg = Storage::url($request->file('images')[0]->store('products', 'public'));

            $product = Product::create([
                'ProductName' => $request->name,
                'CategoryID' => $request->category,
                'ImageURL' => $firtImg,
                'Price' => $request->price,
                'StockQuantity' => $request->stockQuantity,
                'BrandID' => $request->brand,
                'WarrantyPeriod' => $request->warrantyPeriod,
                'Description' => $request->description,
                'VideoLink' => $request->videoLink ?? "",
            ]);

            // Lưu các hình ảnh vào storage/app/public/products
            foreach($request->file('images') as $image){
                $path = $image->store('products', 'public');
                $url = Storage::url($path);
                Productimg::create([
                    'ProductID' => $product->ProductID,
                    'ImgURL' => $url,
                ]);
            }

            //Lưu thông số kỹ thuật
            foreach($request->spec as $spec){
                Productspecification::create([
                    'ProductID' => $product->ProductID,
                    'SpecType' => $spec['key'],
                    'SpecValue' => $spec['value'],
                ]);
            }

            //lưu phiên bản 
            foreach($request->version as $version){
                Productversion::create([
                    'ProductID' => $product->ProductID,
                    'VersionName' => $version['name'],
                    'Price' => $version['price'],
                ]);
            }

            //Lưu các loại màu nếu có
            if($request->has('color') && $request->color[0]['name'] != null){
                foreach($request->color as $color){
                    $path = $color['image']->store('productColors', 'public');
                    $url = Storage::url($path);
                    Productcolor::create([
                        'ProductID' => $product->ProductID,
                        'Color' => $color['name'],
                        'ImgURL' => $url
                    ]);
                }
            }


            DB::commit();
            
            return redirect('/admin');

        }catch (\Exception $e){
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi xảy ra khi tạo sản phẩm: ' . $e->getMessage());
        }
        
    }

    public function edit($id){
        $product = Product::with(['productImgs', 'productSpecifications', 'productVersions', 'productColors','category','brand'])
                  ->find($id);
        $categories = Category::all();

        // dd($product);
        return view('product.edit', ['product' => $product,'categories'=> $categories]);
    }

    public function update(StoreProductRequest $request, $id){
        // dd($request);
        //Validate ở trong file StoreProductRequest
        $request->validated();

        DB::beginTransaction();

        $product = Product::findOrFail($id);

        
        $firstImg = '';
       //Nếu có ảnh mới
       if($request->hasFile('images')){
            // lấy ảnh đầu tiên
            $path = $request->images[0];
            $url = "products/$path"; // đường dẫn trong storage

            if (Storage::disk('public')->exists($url)) {
                // Nếu đã tồn tại thì lấy luôn URL cũ
                $firstImg = Storage::url($url);
            } else {
                // Nếu chưa thì lưu mới
                $storedPath = $path->store('products','public');
                $firstImg = Storage::url($storedPath);
            }
        }else{
            $firstImg = $product->ImageURL;
        }


        $product->update([
            'ProductName' => $request->name,
            'CategoryID' => $request->category, 
            'BrandID' => $request->brand,
            'Price' => $request->price,
            'StockQuantity' => $request->stockQuantity,
            'WarrantyPeriod' => $request->warrantyPeriod,
            'VideoLink' => $request->videoLink,
            'Description' => $request->description,
            'ImageURL' => $firstImg,
        ]);

        //Xóa ảnh được chọn
        if($request->has('delete_images')){
            $imagesToDelete = Productimg::whereIn('ImgID', $request->delete_images)
                                        ->where('ProductID', $product->ProductID)
                                        ->get();
            
            
            foreach($imagesToDelete as $image){
                // Cắt chữ /storage/ khỏi URL
                $path = str_replace('/storage/','',$image->ImgURL);
                Storage::disk('public')->delete($path);

                // Xóa khỏi DB
                $image->delete();
            }
        }

        //Nếu có ảnh mới
        if($request->hasFile('images')){
            foreach($request->file('images') as $image){
                $path = $image->store('products', 'public');
                $url = Storage::url($path);

                Productimg::create([
                    'ProductID' => $product->ProductID,
                    'ImgURL' => $url,
                ]);
            }
        }

        //Cập nhật phiên bản sản phẩm
        if($request->has('version')){
            //Xóa phiên bản cũ
            $product->productVersions()->delete();

            //Thêm kiểu mới
            foreach($request->version as $version){
                If(!empty($version['name']) && !empty($version['price'])){
                    Productversion::create([
                        'ProductID' => $product->ProductID,
                        'VersionName' => $version['name'],
                        'Price' => $version['price'],
                    ]);
                }
            }
        }

        //Cập nhật thông số kỹ thuật
        if($request->has('spec')){
            //Xóa phiên bản cũ
            $product->productSpecifications()->delete();

            //Thêm kiểu mới
            foreach($request->spec as $spec){
                If(!empty($spec['key']) && !empty($spec['value'])){
                    Productspecification::create([
                        'ProductID' => $product->ProductID,
                        'SpecType' => $spec['key'],
                        'SpecValue' => $spec['value'],
                    ]);
                }
            }
        }


        //Cập nhật màu sắc sản phẩm nếu có
        if ($request->has('color')) {
            foreach ($request->color as $color) {
                //Kiểm tra xem có color nào được chỉnh sửa không
                if (!empty($color['name'])) {
                    $imgUrl = null;
        
                    // Nếu có file ảnh mới
                    if (!empty($color['image']) && $color['image'] instanceof \Illuminate\Http\UploadedFile) {
                        // Nếu có old_image thì xóa file cũ
                        if (!empty($color['old_image'])) {
                            $oldPath = str_replace('/storage/','',$color['old_image']);
                            Storage::disk('public')->delete($oldPath);
                        }
        
                        // Lưu ảnh mới
                        $path = $color['image']->store('productColors', 'public');
                        $imgUrl = Storage::url($path);
                    } else {
                        // Không có file mới thì giữ ảnh cũ
                        $imgUrl = $color['old_image'] ?? null;
                    }
        
                    // Lưu DB 
                    Productcolor::updateOrCreate(
                        [
                            'ProductID' => $product->ProductID,
                            'Color' => $color['name'], 
                        ],
                        [
                            'ImgURL' => $imgUrl,
                        ]
                    );
                }
            }
        }

        //Kiểm tra xem có color nào bị xóa đi không
        $colors = Productcolor::where('ProductID',$id)->get();
        $requestColors = $request->input('color', []); // Lấy array colors từ request
        $colorNames = [];

        foreach ($requestColors as $colorId => $colorData) {
            $colorNames[] = $colorData['name'];
        }

        foreach($colors as $color){
            if(!in_array($color->Color, $colorNames)){
                $oldPath = str_replace('/storage/','',$color->ImgURL);
                Storage::disk('public')->delete($oldPath);

                $color->delete();
            }
        }


        DB::commit();
        
        return redirect('/admin/')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroy($id){
        DB::beginTransaction();

        try{
            $product = Product::findOrFail($id);

            if($product->ImageURL){
                $imagePath = str_replace('/storage/', '', $product->ImageURL);
                Storage::disk('public')->delete($imagePath);
            }

            // Xóa các ảnh sản phẩm và file tương ứng
            $productImages = Productimg::where('ProductID', $product->ProductID)->get();
            foreach($productImages as $image){
                if($image->ImgURL){
                    $imagePath = str_replace('/storage/', '', $image->ImgURL);
                    Storage::disk('public')->delete($imagePath);
                }
            }

            //Xóa các ảnh màu sắc và file tương ứng
            $productColors = Productcolor::where('ProductID', $product->ProductID)->get();
            foreach($productColors as $color){
                if($color->ImgURL){
                    $imagePath = str_replace('/storage/', '', $color->ImgURL);
                    Storage::disk('public')->delete($imagePath);
                }
            }

            //Xóa sản phẩm chính
            $product->delete();

            DB::commit();

            return redirect('/admin')->with('success', "Sản phẩm đã được xóa thành công!");
        }catch(\Exception $e){
            DB::rollBack();

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm'. $e->getMessage());
        }
    }

    public function search(Request $request){
        $query = Product::with(['category','brand']);
        if($request->has('input')&& !empty($request->input)){
            $keyword = $request->input;
            $query->where('ProductName','like',"%{$keyword}%");
                // ->orWhereHas('category', function($q) use ($keyword) {
                //     $q->where('CategoryName','like',"%{$keyword}%");
                // })
                // ->orWhereHas('brand', function($q) use ($keyword) {
                //     $q->where('BrandName','like',"%{$keyword}%");
                // });
        }

        if($request->has('category') && !empty($request->category)){
            $query->whereHas('category', function($q) use ($request){
                $q->where('CategoryID',$request->category);
            });
        }

        if($request->has('brand') && !empty($request->brand)){
            $query->whereHas('brand', function($q) use ($request){
                $q->where('BrandID',$request->brand);
            });
        }

        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('Price', [$request->price_min, $request->price_max]);
        }

        if ($request->has('sort') && $request->sort == 'newest') {
            $query->orderBy('CreatedAt', 'desc');
        }

        $products = $query->get();

        return view('product.dashboard', ['products' => $products]);
    }

    public function searchForCus(Request $request){
        $query = Product::with(['category','brand']);
        if($request->has('input')&& !empty($request->input)){
            $keyword = $request->input;
            $query->where('ProductName','like',"%{$keyword}%");
                // ->orWhereHas('category', function($q) use ($keyword) {
                //     $q->where('CategoryName','like',"%{$keyword}%");
                // })
                // ->orWhereHas('brand', function($q) use ($keyword) {
                //     $q->where('BrandName','like',"%{$keyword}%");
                // });
        }

        if($request->has('category') && !empty($request->category)){
            $query->whereHas('category', function($q) use ($request){
                $q->where('CategoryID',$request->category);
            });
        }

        if($request->has('brand') && !empty($request->brand)){
            $query->whereHas('brand', function($q) use ($request){
                $q->where('BrandID',$request->brand);
            });
        }

        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('Price', [$request->price_min, $request->price_max]);
        }

        if ($request->has('sort')) {
            switch($request->sort){
                case 'oldest':
                    $query->orderBy('CreatedAt', 'asc');
                    break;
                case 'low-to-high':
                    $query->orderBy('Price','asc');
                    break;
                case 'high-to-low':
                    $query->orderBy('Price','desc');
                    break;
                default:
                    $query->orderBy('CreatedAt', 'desc');
                    break;
            }
        }

        $products = $query->get();
        $categories = Category::all();

        return view('product.catalogSearch', ['products' => $products,'categories' => $categories]);
    }
}
