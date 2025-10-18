<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cartitem;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\Productversion;
use Exception;

class CartController extends Controller
{
    public function index(){
        //auth()->user() - người dùng hiện tại
        // auth()->user()->UserID - lấy ID người dùng hiện tại
        $cart = Cart::where('UserID', auth()->user()->UserID)
                        ->where('Completed', false)
                        ->first();
        
        if(!$cart){
            return view('cart.index',['cartitems' => []]);
        }

        $cartItems = CartItem::where('CartID', $cart->CartID)
                                    ->with(['product','version','color'])
                                    ->get();

        return view('cart.index',['cartitems' => $cartItems]);
    }

    public function addItem(Request $request){
        try{
            //Kiểm tra xem người dùng đã đăng nhập hay chưa
            if(!auth()){
                return redirect()->back()->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
            }

            $userID = auth()->user()->UserID;

            //Validate
            $request->validate([
                'productID' => 'required|exists:products,ProductID',
                'versionID' => 'nullable|exists:productversions,VersionID',
                'colorID' => 'nullable|exists:productcolors,ColorID',
                'quantity' => 'nullable|integer|min:1',
            ]);

            //Kiểm tra số lượng tồn kho của sản phẩm. còn thì mới cho mua
            $product = Product::find($request->productID);
            if($product->StockQuantity <1){
                return redirect()->back()->with('warning','Sản phẩm đã hết hàng!');
            }

            //TÌm hoặc tạo giỏ hàng
            $cart = Cart::firstOrCreate([
                'UserID' => $userID,
                'Completed' => false
            ],
            [
                'UserID' => $userID,
                'Completed' => false
            ]);

            //Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $cartItemQuery = Cartitem::where('CartID', $cart->CartID)
                    ->where('ProductID', $request->productID);
            
            if($request->versionID){
                $cartItemQuery->where('VersionID', $request->versionID);
            }else{
                $cartItemQuery->whereNull('VersionID');
            }

            if($request->colorID){
                $cartItemQuery->where('ColorID', $request->colorID);
            }else{
                $cartItemQuery->whereNull('ColorID');
            }

            $cartItem = $cartItemQuery->first();
            
            if($cartItem){
                //Nếu đã có thì tăng số lượng sản phẩm đó lên
                $cartItem->increment('Quantity');
                $message = 'Đã cập nhật số lượng sản phẩm tỏng giỏ hàng';
            }else{
                //Nếu chưa có sản phẩm thì thêm mới
                Cartitem::create([
                    'CartID' => $cart->CartID,
                    'ProductID' => $request->productID,
                    'VersionID' => $request->versionID,
                    'ColorID' => $request->colorID,
                    'Quantity' => $request->quantity ?? 1
                ]);
                $message = 'Thêm sản phẩm vào giỏ hàng thành công!';
            }

            return redirect()->back()->with('success',$message);

            
        }catch(\Exception $e){
            return redirect()->back()->with('error','Thêm sản phẩm thất bại'. $e->getMessage());
        }
    }

    public function increaseQuantity(Request $request,$id){
        try {
            // Kiểm tra đăng nhập
            if (!auth()->user()) {
                return redirect()->back()->with('error', 'Vui lòng đăng nhập để thực hiện thao tác này');
            }

            // Tìm cart item và kiểm tra quyền sở hữu
            $cartItem = CartItem::where('CartItemID', $id)
                            ->whereHas('cart', function($query) {
                                $query->where('UserID', auth()->user()->UserID)
                                    ->where('Completed', false);
                            })
                            ->first();

            if (!$cartItem) {
                return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng');
            }

            // Kiểm tra tồn kho
            $currentStock = $cartItem->product->StockQuantity;
            
            if ($cartItem->Quantity >= $currentStock) {
                return redirect()->back()->with('warning', 'Số lượng vượt quá tồn kho. Chỉ còn ' . $currentStock . ' sản phẩm');
            }

            // Tăng số lượng
            $cartItem->increment('Quantity');

            return redirect()->back()->with('success', 'Đã tăng số lượng sản phẩm');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function decreaseQuantity(Request $request, $id){
        try {
            if (!auth()->user()) {
                return redirect()->back()->with('error', 'Vui lòng đăng nhập');
            }

            $cartItem = CartItem::where('CartItemID', $id)
                ->whereHas('cart', function($query) {
                    $query->where('UserID', auth()->user()->UserID);
                })
                ->first();

            if (!$cartItem) {
                return redirect()->back()->with('error', 'Không tìm thấy sản phẩm');
            }

            // Giảm số lượng, nếu = 1 thì xóa
            if ($cartItem->Quantity <= 1) {
                $cartItem->delete();
                return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
            }

            $cartItem->decrement('Quantity');

            return redirect()->back()->with('success', 'Đã giảm số lượng');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra');
        }
    }

    public function remove($id){
        try{
            if(!auth()->user()){
                return redirect()->back()->with('error','Vui lòng đăng nhập!');
            }

            $cartItem = Cartitem::where('CartItemID',$id)->first();
            if(!$cartItem){
                return redirect()->back()->with('error','Không tìm thấy sản phẩm');
            }

            $cartItem->delete();

            return redirect()->back()->with('success','Xóa sẩn phẩm khỏi giỏ hàng thành công');
        }catch(Exception $e){
            return redirect()->back()->with('error','Có lỗi xảy ra: '. $e->getMessage());
        }
        
    }
}
