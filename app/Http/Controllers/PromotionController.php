<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
     /**
     * Hiển thị danh sách các khuyến mãi.
     */
    public function index()
    {
        $promotions = Promotion::all();
        return view('promotion.index', compact('promotions'));
    }

    /**
     * Hiển thị form để tạo khuyến mãi mới.
     */
    public function create()
    {
        return view('promotion.create');
    }

    /**
     * Lưu khuyến mãi mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        //dd($request);
        DB::beginTransaction();

        $request->validate([
            'Title' => 'required|string|max:100',
            'Description' => 'nullable|string',
            'DiscountPercent' => 'nullable|numeric|max:100',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'Img' => 'required',
        ]);
        $generatedImg = 'Img' .time(). '_'
                            .$request->name. '.'
                            .$request->Img->extension();
        $request->Img->move(public_path('ads'),  $generatedImg);

         try {
        

        $promotion = Promotion::create([
            'Title' => $request-> Title,
            'Description' => $request-> Description,
            'DiscountPercent' => $request-> DiscountPercent,
            'StartDate' => $request-> StartDate,
            'EndDate' => $request-> EndDate,
            'ImgURL' => $generatedImg
        ]);
        $promotion->save();

        DB::commit();

        return redirect()->route('promotion.index')->with('success', 'Khuyến mãi đã được tạo thành công!');

        }catch (\Exception $e){
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi xảy ra khi tạo sản phẩm: ' . $e->getMessage());
        }
    }
    /**
     * Hiển thị form để chỉnh sửa khuyến mãi.
     */
    public function edit(Promotion $promotion)
    {
        return view('promotion.edit', compact('promotion'));
    }

    /**
     * Cập nhật khuyến mãi đã tồn tại.
     */
 public function update(Request $request, Promotion $promotion)
{
    // Cập nhật lại validate để phù hợp với việc tải file
    $request->validate([
        'Title' => 'required|string|max:100',
        'Description' => 'nullable|string',
        'DiscountPercent' => 'nullable|numeric|max:100',
        'StartDate' => 'nullable|date',
        'EndDate' => 'nullable|date|after_or_equal:StartDate',
        'Img' => 'nullable|image|max:5084', // Validate cho file ảnh (5MB)
    ]);

    DB::beginTransaction();

    // Đối tượng $promotion đã được tự động lấy từ Route Model Binding
    // Dòng này không cần thiết: $promotion = Promotion::findOrFail($promotion);

    // Chuẩn bị dữ liệu để cập nhật
    $dataToUpdate = $request->except(['_token', '_method']);

    // Xử lý tệp tin được tải lên (nếu có)
    if ($request->hasFile('Img')) {
        // Xóa hình ảnh cũ (nếu tồn tại)
        if ($promotion->ImgURL) {
            Storage::disk('public')->delete($promotion->ImgURL);
        }

        // Lưu tệp tin mới vào thư mục 'ads' trên đĩa 'public'
        $path = $request->file('Img')->store('ads', 'public');
        $dataToUpdate['ImgURL'] = $path;
    }

    // Cập nhật bản ghi
    $promotion->update($dataToUpdate);

    DB::commit();

    return redirect()->route('promotion.index')->with('success', 'Khuyến mãi đã được cập nhật thành công!');
}

    /**
     * Xóa khuyến mãi.
     */
    public function destroy(Promotion $promotion)
    {
        // Kiểm tra xem đối tượng promotion có trường ImgURL không
    if ($promotion->ImgURL) {
        // Đường dẫn của file ảnh trong thư mục storage/app/public
        $imagePath = $promotion->ImgURL;
        
        // Kiểm tra xem file có tồn tại không
        if (Storage::disk('public')->exists($imagePath)) {
            // Xóa file ảnh vật lý
            Storage::disk('public')->delete($imagePath);
        }
    }
        $promotion->delete();

        return redirect()->route('promotion.index')->with('success', 'Khuyến mãi đã được xóa thành công!');
    }

    public function getPromotions()
    {
        $promotions = Promotion::all();
        return response()->json($promotions);
    }

    
}
