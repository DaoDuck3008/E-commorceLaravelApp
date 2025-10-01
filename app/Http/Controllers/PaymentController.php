<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function vnPay(Request $request)
    {
        $vnp_TmnCode = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url = config('services.vnpay.url');
        $vnp_Returnurl = config('services.vnpay.return');

        $vnp_TxnRef = $request->orderID; // hoặc lấy id đơn hàng đã tạo trong DB
        $vnp_OrderInfo = "Thanh toán đơn hàng #{$vnp_TxnRef}";
        $vnp_Amount = $request->amount * 100; // nhân 100 vì VNPAY yêu cầu
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();
        $vnp_OrderType = 'billpayment';


        $startTime = date("YmdHis");
        $vnp_ExpireDate =  date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));


        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $vnp_Amount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            'vnp_ReturnUrl' => $vnp_Returnurl,
            'vnp_TxnRef' => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate
        ];

        // Loại bỏ các tham số có giá trị rỗng
        $inputData = array_filter($inputData, function($value) {
            return $value !== null && $value !== '';
        });

        // Sắp xếp tham số theo tên (dictionary order)
        ksort($inputData);
        
        $hashdata = "";
        $query = "";
        $i = 0;
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        
        // Tạo secure hash
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        return redirect()->away($vnp_Url); 
    }

    public function return(Request $request)
    {
        $input = $request->all();
        $vnp_SecureHash = $input['vnp_SecureHash'] ?? '';
        
        // Loại bỏ các tham số không cần thiết cho việc hash
        unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);
        
        // Sắp xếp tham số theo key
        ksort($input);
        
        $hashdata = "";
        $i = 0;
        foreach ($input as $key => $value) {
            // Bỏ qua các giá trị rỗng
            if ($value === '' || $value === null) {
                continue;
            }
            
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
    
        $secureHash = hash_hmac('sha512', $hashdata, config('services.vnpay.hash_secret'));
        
        if (strtoupper($secureHash) === strtoupper($vnp_SecureHash)) {
            // Kiểm tra trạng thái giao dịch từ VNPay
            if ($request->vnp_ResponseCode == '00') {
                $orderId = $request->vnp_TxnRef; 
                $order = Order::find($orderId);
    
                if ($order) {
                    // Cập nhật trạng thái đơn hàng thành đã thanh toán
                    Payment::where('OrderID', $order->orderID)
                                    ->update([
                                        'STATUS' => 'Paid',
                                    ]);
                    
                    return redirect()
                        ->route('order.confirmation', $order->OrderID)
                        ->with('success', 'Thanh toán thành công!');
                } else {
                    return redirect()->route('cart.index')->with('error', 'Không tìm thấy đơn hàng.');
                }
            } else {
                // Giao dịch thất bại từ phía VNPay
                $errorMessage = $this->getResponseDescription($request->vnp_ResponseCode);
                return redirect()->route('cart.index')->with('error', 'Thanh toán thất bại: ' . $errorMessage);
            }
        } else {
            return redirect()->route('cart.index')->with('error', 'Xác thực chữ ký thất bại. Có thể có sự can thiệp từ bên ngoài.');
        }
    }
    
    // Hàm lấy mô tả mã lỗi từ VNPay
    private function getResponseDescription($responseCode)
    {
        $responseMap = [
            '00' => 'Giao dịch thành công',
            '01' => 'Giao dịch chưa hoàn tất',
            '02' => 'Giao dịch bị lỗi',
            '04' => 'Giao dịch đảo (Khách hàng đã bị trừ tiền tại Ngân hàng nhưng GD chưa thành công ở VNPAY)',
            '05' => 'VNPAY đang xử lý giao dịch này (GD hoàn tiền)',
            '06' => 'VNPAY đã gửi yêu cầu hoàn tiền sang Ngân hàng (GD hoàn tiền)',
            '07' => 'Giao dịch bị nghi ngờ gian lận',
            '09' => 'GD Hoàn trả bị từ chối',
            '10' => 'Đã hoàn tiền thành công',
            '11' => 'Đã hoàn tiền thất bại',
            '12' => 'Đang xử lý yêu cầu hoàn tiền',
            '13' => 'Yêu cầu hoàn tiền bị từ chối',
            '24' => 'Giao dịch bị huỷ',
            '51' => 'Tài khoản không đủ tiền',
            '65' => 'Tài khoản vượt quá hạn mức giao dịch trong ngày',
            '75' => 'Ngân hàng thanh toán đang bảo trì',
            '79' => 'Khách hàng nhập sai mật khẩu thanh toán quá số lần quy định',
            '99' => 'Các lỗi khác'
        ];
    
        return $responseMap[$responseCode] ?? 'Mã lỗi không xác định: ' . $responseCode;
    }

}
