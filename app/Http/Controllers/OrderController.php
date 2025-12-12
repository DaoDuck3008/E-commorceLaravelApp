<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Cartitem;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\Productversion;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function buyNow(Request $request){
        try{
            if(!auth()){
                return redirect()->back()->with('error','Vui lòng đăng nhập để dùng chức năng này!');
            }

            $userID = auth()->user()->UserID;

            // validate
            $request->validate([
                'productID' => 'required|exists:products,ProductID',
                'versionID' => 'nullable|exists:productversions,VersionID',
                'colorID' => 'nullable|exists:productcolors,ColorID',
                'quantity' => 'nullable|integer|min:1',
            ]);

            // Kiểm tra product tồn tại
            $product = Product::find($request->productID);
            if (!$product) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
            }

            //Kiểm tra số lượng tồn kho của sản phẩm. còn thì mới cho mua
            $product = Product::find($request->productID);
            if($product->StockQuantity <1){
                return redirect()->back()->with('warning','Sản phẩm đã hết hàng!');
            }

            //Kiểm tra phiên bản (nếu có)
            if($request->versionID){
                $version = Productversion::where('VersionID', $request->versionID)
                            ->where('ProductID', $request->productID)
                            ->first();
                if(!$version){
                    return redirect()->back()->with('error','Phiên bản sản phẩm không hợp lệ!');
                }
            }

            //Kiểm tra màu sắc (nếu có)
            if($request->colorID){
                $color = Productcolor::where('ColorID', $request->colorID)
                            ->where('ProductID', $request->productID)
                            ->first();
                if(!$color){
                    return redirect()->back()->with('error','Màu sắc sản phẩm không hợp lệ');
                }
            }

            //TÌm hoặc tạo giỏ hàng
            $cart = Cart::create([
                'UserID' => $userID,
                'Completed' => false
            ]);

            $cartItem = Cartitem::create([
                'CartID' => $cart->CartID,
                'ProductID' => $request->productID,
                'VersionID' => $request->versionID,
                'ColorID' => $request->colorID,
                'Quantity' => $request->quantity ?? 1
            ]);


            return redirect()->route('checkout',['selectedId' => $cartItem->CartItemID]);

        }catch(\Exception $e){

            return redirect()->back()->with('error','Có lỗi xảy ra: '. $e->getMessage());
        }
    }

    public function index(Request $request){
        if(!auth()->check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
        }

        $buyNow = false; // Mặc định là false

        if($request->has('selectedId')){
            $cartItems = Cartitem::where('CartItemID', $request->selectedId)
                ->whereHas('cart', function($query){
                    $query->where('UserID', auth()->user()->UserID)
                        ->where('Completed', false);
                })
                ->with(['product','version','color'])
                ->get();
            

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Không tìm thấy sản phẩm');
            }

            $selectedIds = [$request->selectedId];
            $buyNow = true; // ← Đặt thành true khi buyNow
        } else {
            $selectedIds = explode(',', $request->items);

            $cartItems = Cartitem::whereIn('CartItemID', $selectedIds)
                ->whereHas('cart', function($query){
                    $query->where('UserID', auth()->user()->UserID)
                        ->where('Completed', false);
                })
                ->with(['product','version','color'])
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Không tìm thấy sản phẩm');
            }
        }
        
        // Luôn truyền biến buyNow
        return view('order.index', [
            'cartItems' => $cartItems, 
            'selectedIds' => $selectedIds,
            'buyNow' => $buyNow 
        ]);
    }

    public function processCheckout(Request $request){
        // dd($request);

        DB::beginTransaction();

        try{
            if(!auth()){
                return redirect()->back()->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
            }

            $userID = auth()->user()->UserID;
            $selectedIds = $request->selectedIds;


            //Validate
            $validated = $request->validate([
                'city' => 'required|string',
                'district' => 'required|string',
                'address' => 'required|string',
                'phone' => 'nullable|string',
                'description' => 'nullable|string',
                'paymentMethod' => 'required|string|in:cod,bankTransfer',
            ]);

            //lấy giỏ hàng hiện tại
            $cart = Cart::where('UserID', $userID)
                        ->where('Completed',false)
                        ->firstOrFail();

            $cartItems = Cartitem::whereIn('CartItemID', $selectedIds)
                        ->where('CartID', $cart->CartID)
                        ->with(['product','version','color'])
                        ->get();


            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Không có sản phẩm trong giỏ hàng 1');
            }

            // tính tổng tiền
            $totalAmount = 0;
            foreach($cartItems as $item){
                $price = $item->version->Price ?? $item->product->Price;
                $totalAmount += $price * $item->Quantity;
            }

            // Tạo order
            $order = Order::create([
                'UserID' => $userID,
                'OrderDate' => now(),
                'TotalAmount' => $totalAmount,
                'STATUS' => 'pending',
                'ShippingAddress' => $this->buildAddressString($validated),
                'PaymentMethod' => $validated['paymentMethod'],
                'Description' => $request->description ?? ''
            ]);

            // Tạo order items
            foreach($cartItems as $item){
                $price = $item->version->Price ?? $item->product->Price;

                Orderitem::create([
                    'OrderID' => $order->OrderID,
                    'ProductID' => $item->ProductID,
                    'Quantity' => $item->Quantity,
                    'Price' => $price,
                    'VersionID' => $item->VersionID,
                    'ColorID' => $item->ColorID,
                ]);

                // Cập nhật số lượng kho
                $item->product->decrement('StockQuantity',$item->Quantity);
            }

            // Tạo payment record 
            $payment = Payment::create([
                'OrderID' => $order->OrderID,
                'PaymentDate' => now(),
                'Amount' => $totalAmount,
                'PaymentMethod' => $validated['paymentMethod'],
                'STATUS' => 'Processing',
            ]);

            // Đánh dấu giỏ hàng đã hoàn thành
            $cart->update([
                'Completed' => true,
                'UpdatedAt' => now()
            ]);

            // Cập nhật lại giỏ hàng hiện tại
            foreach($cartItems as $item){
                $item->delete();
            }

            DB::commit();

            if($validated['paymentMethod'] === 'bankTransfer'){
                $amount= $totalAmount;
                return redirect()->route('payment.vnpay',['amount'=> $amount,'orderID' => $order->OrderID]);
            }

            return redirect()->route('order.confirmation',$order->OrderID)->with('success','Đặt hàng thành công!');


        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' .$e->getMessage());
        }
    }

    public function processCheckoutBuyNow(Request $request){
        // dd($request);

        DB::beginTransaction();

        try{
            if(!auth()){
                return redirect()->back()->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
            }

            $cartID = $request->cartID;
            $userID = auth()->user()->UserID;
            $selectedIds = $request->selectedIds;


            //Validate
            $validated = $request->validate([
                'city' => 'required|string',
                'district' => 'required|string',
                'address' => 'required|string',
                'phone' => 'nullable|string',
                'description' => 'nullable|string',
                'paymentMethod' => 'required|string|in:cod,bankTransfer',
            ]);

            //lấy giỏ hàng hiện tại
            $cart = Cart::where('CartID', $cartID)
                        ->where('UserID', $userID)
                        ->where('Completed',false)
                        ->firstOrFail();

            $cartItems = Cartitem::whereIn('CartItemID', $selectedIds)
                        ->where('CartID', $cart->CartID)
                        ->with(['product','version','color'])
                        ->get();


            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Không có sản phẩm trong giỏ hàng 2');
            }

            // tính tổng tiền
            $totalAmount = 0;
            foreach($cartItems as $item){
                $price = $item->version->Price ?? $item->product->Price;
                $totalAmount += $price * $item->Quantity;
            }

            // Tạo order
            $order = Order::create([
                'UserID' => $userID,
                'OrderDate' => now(),
                'TotalAmount' => $totalAmount,
                'STATUS' => 'pending',
                'ShippingAddress' => $this->buildAddressString($validated),
                'PaymentMethod' => $validated['paymentMethod'],
                'Description' => $request->description ?? ''
            ]);

            // Tạo order items
            foreach($cartItems as $item){
                $price = $item->version->Price ?? $item->product->Price;

                Orderitem::create([
                    'OrderID' => $order->OrderID,
                    'ProductID' => $item->ProductID,
                    'Quantity' => $item->Quantity,
                    'Price' => $price,
                    'VersionID' => $item->VersionID,
                    'ColorID' => $item->ColorID,
                ]);

                // Cập nhật số lượng kho
                $item->product->decrement('StockQuantity',$item->Quantity);
            }

            // Tạo payment record 
            $payment = Payment::create([
                'OrderID' => $order->OrderID,
                'PaymentDate' => now(),
                'Amount' => $totalAmount,
                'PaymentMethod' => $validated['paymentMethod'],
                'STATUS' => 'Processing',
            ]);

            // Đánh dấu giỏ hàng đã hoàn thành
            $cart->update([
                'Completed' => true,
                'UpdatedAt' => now()
            ]);

            // Cập nhật lại giỏ hàng hiện tại
            foreach($cartItems as $item){
                $item->delete();
            }

            DB::commit();

            if($validated['paymentMethod'] === 'bankTransfer'){
                $amount= $totalAmount;
                return redirect()->route('payment.vnpay',['amount'=> $amount,'orderID' => $order->OrderID]);
            }

            return redirect()->route('order.confirmation',$order->OrderID)->with('success','Đặt hàng thành công!');

        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' .$e->getMessage());
        }
    }

    public function confirmation($orderId){
        $order = Order::where('OrderID', $orderId)
                        ->where('UserID', auth()->user()->UserID)
                        ->with(['orderitems.product','orderitems.color','orderitems.version','payments'])
                        ->first();


        return view('order.confirmation', ['order' => $order]);                
    }

    public function history(){
        $orders = Order::with(['orderitems.product'])
                    ->where('UserID', auth()->user()->UserID)
                    ->orderBy('OrderDate', 'desc')
                    ->paginate(10);

        return view('order.history',['orders' => $orders]);
    }

    public function historyAPI(){
        $orders = Order::with(['orderitems.product'])
                    ->where('UserID', auth()->user()->UserID)
                    ->orderBy('OrderDate', 'desc')
                    ->paginate(4);

       return response()->json($orders);
    }

    public function show($orderId){
        $order = Order::with(['orderitems.product','orderitems.version','orderitems.color','payments'])
                    ->where('OrderID',$orderId)
                    ->where('UserID', auth()->user()->UserID)
                    ->firstOrFail();

        if(!$order){
            return redirect()->back()->with('error','Không tìm thấy đơn hàng!');
        }

        return view('order.detail',['order'=> $order]);
    }

    public function cancel(Request $request,$orderId){
        $request->validate([
            'reason' => 'required|string',
        ]);

        DB::beginTransaction();
        try{
            $order = Order::where('OrderID', $orderId)
                        ->where('UserID', auth()->user()->UserID)
                        ->where('STATUS', 'Pending')
                        ->firstOrFail();

            foreach($order->orderitems as $item){
                $item->product->increment('StockQuantity',$item->Quantity);
            }

            $order->payments->first()->update(['STATUS' => 'Cancelled']);
            $order->update([
                'STATUS' => 'Cancelled',
                'CancelReason' =>'Khách hàng hủy vì: '. $request->reason
            ]);


            DB::commit();

            return redirect()->back()->with('success','Đã hủy đơn hàng');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','Có lỗi xảy ra: '. $e->getMessage());
        }
    }

    public function dashboard(){
        $orders = Order::with(['orderitems.product','payments','user'])
                            ->orderBy('OrderDate', 'desc')                
                            ->paginate(25);
        
        $orderitems = Orderitem::first();

        return view('order.dashboard',['orders'=> $orders,'orderitems' => $orderitems]);
    }

    public function showAdmin($orderId){
        $order = Order::with(['orderitems.product','orderitems.version','orderitems.color','payments'])
                    ->where('OrderID',$orderId)
                    ->firstOrFail();
        
        if(!$order){
            return redirect()->back()->with('error','Không tìm thấy đơn hàng!');
        }

        return view('order.detailAdmin',['order' => $order]);
    }

    public function updateSTATUS(Request $request, $orderId){
        $order = Order::with(['orderitems.product','orderitems.version','orderitems.color','payments'])
                    ->where('OrderID',$orderId)
                    ->firstOrFail();

        if(!$order){
            return redirect()->back()->with('error','Không tìm thấy đơn hàng!');
        }

        // Nếu đơn hàng đã bị hủy thì không được cập nhật nữa
        if($order->STATUS === 'Cancelled'){
            return redirect()->back()->with('error','Đơn hàng đã bị hủy bạn không thể cập nhật nữa!');
        }

        $updatedSTATUS = '';
        switch($order->STATUS){
            case('Pending'):
                $updatedSTATUS = 'Confirmed';
                break;
            case('Confirmed'):
                $updatedSTATUS = 'Shipped';
                break;
            case('Shipped'):
                $updatedSTATUS = 'Completed';
                break;
            default:
                $updatedSTATUS = 'Pending';
                break;
        }

        $order->update([
            'STATUS' => $updatedSTATUS
        ]);

        if($updatedSTATUS === 'Completed'){
            Payment::where('OrderID',$order->OrderID)
                        ->update([
                            'STATUS' => 'Paid'
                        ]);
        }
        
        return redirect()->back()->with('success','Cập nhật trạng thái đơn hàng thành công');
    }

    public function cancelByAdmin(Request $request,$orderId){
        $request->validate([
            'reason' => 'required|string',
        ]);

        DB::beginTransaction();
        try{
            $order = Order::where('OrderID',$orderId)->firstOrFail();

            if($order->STATUS !== 'Pending'){
                return redirect()->back()->with('error','Bạn không thể xóa đơn hàng này!');
            }

            foreach($order->orderitems as $item){
                $item->product->increment('StockQuantity',$item->Quantity);
            }

            $order->payments->first()->update(['STATUS' => 'Cancelled']);
            $order->update([
                'STATUS' => 'Cancelled',
                'CancelReason' =>'Nhân viên cửa hàng hủy vì: '. $request->reason
            ]);

            DB::commit();

            return redirect()->back()->with('success','Đã hủy đơn hàng');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','Có lỗi: '. $e->getMessage());
        }
    }

    private function buildAddressString($data)
    {
        return implode(', ', [
            $data['address'],
            $data['district'],
            $data['city']
        ]);
    }
}
