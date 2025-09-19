<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    
    public function update(Request $request, $id)
    {
        $request->validate([
        'comment' => 'required|string|max:1000',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $review = Review::findOrFail($id);

    // Kiểm tra quyền chỉnh sửa
    if (auth()->id() !== $review->UserID) {
        return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa bình luận này.');
    }

    $review->COMMENT = $request->comment;
    $review->Rating = $request->rating;
    $review->save();

    return redirect()->back()->with('success', 'Cập nhật bình luận thành công!');
    }



        // Lưu bình luận mới
      public function store(Request $request)
{
    $request->validate([
        'ProductID' => 'required|exists:products,ProductID',
        'rating' => 'required|integer|min:1|max:5',
        'COMMENT' => 'required|string|max:1000',
    ]);

    Review::create([
        'ProductID' => $request->ProductID,
        'UserID' => Auth::id(),
        'Rating' => $request->rating,
        'COMMENT' => $request->COMMENT,
    ]);

    return redirect()->back()->with('success', 'Bình luận đã được gửi!');
}

    // Xóa bình luận
    public function destroy($id)
{
    $review = Review::findOrFail($id);

    // Chỉ cho xóa nếu là admin hoặc chính chủ
    if (auth()->user()->Role !== 'Admin' && auth()->id() !== $review->UserID) {
        return redirect()->back()->with('Error', 'Bạn không có quyền xóa bình luận này.');
    }

    $review->delete();

    return redirect()->back()->with('Success', 'Xóa bình luận thành công!');
}

}
