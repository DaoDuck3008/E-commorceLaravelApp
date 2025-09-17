@extends('layouts.appWithoutFooter')

@section('style')
<style>
    .confirmation-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
        background: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .order-timeline {
        position: relative;
        padding-left: 30px;
        margin: 2rem 0;
    }
    
    .order-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dc3545;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #dc3545;
        border: 3px solid white;
        box-shadow: 0 0 0 3px #dc3545;
    }
    
    .product-image-confirm {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #eee;
    }
    
    .status-badge {
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 20px;
    }
    
    .action-buttons .btn {
        border-radius: 25px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .order-detail-card {
        border-left: 4px solid #dc3545;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .payment-info {
        background: linear-gradient(135deg, #ff6b6b 0%, #dc3545 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .back-home-btn {
        background-color: #28a745; 
        color:white; 
        font-weight: 600
    }
    
    .back-home-btn:hover {
        background-color: #1f7b34;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="confirmation-container py-5">
    <div class="container">
        <!-- Header -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <div class="success-icon mb-3">
                        <i class="fas fa-check fa-2x text-white"></i>
                    </div>
                    <h1 class="display-5 fw-bold text-success mb-3">Đặt Hàng Thành Công!</h1>
                    <p class="lead text-muted">Cảm ơn bạn đã đặt hàng tại SuperDevices</p>
                    <a class="back-home-btn btn p-2" href="{{ route('home') }}" style="">
                        Trở về trang chủ
                    </a>
                </div>

                <!-- Order Summary -->
                <div class="card order-detail-card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">THÔNG TIN ĐƠN HÀNG</h6>
                                <p><strong>Mã đơn hàng:</strong> #{{ $order->OrderID }}</p>
                                <p><strong>Ngày đặt:</strong> {{ $order->OrderDate->format('d/m/Y H:i') }}</p>
                                <p><strong>Trạng thái:</strong> 
                                    <span class="badge status-badge bg-{{ $order->STATUS == 'confirmed' ? 'success' : 'warning' }}">
                                        {{ $order->STATUS == 'confirmed' ? 'Đã xác nhận' : 'Chờ xác nhận' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">THÔNG TIN GIAO HÀNG</h6>
                                <p><strong>Người nhận:</strong> {{ $order->user->FullName }}</p>
                                <p><strong>Điện thoại:</strong> {{ $order->user->PhoneNumber }}</p>
                                <p><strong>Địa chỉ:</strong> {{ $order->ShippingAddress }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">SẢN PHẨM ĐÃ ĐẶT</h6>
                        @foreach ($order->orderitems as $item)
                        <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                            <img src="{{ $item->product->ImageURL }}" 
                                 alt="{{ $item->product->ProductName }}"
                                 class="product-image-confirm me-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item->product->ProductName }}</h6>
                                <p class="text-muted small mb-1">
                                    Phiên bản: {{ $item->version->VersionName ?? 'Mặc định' }} - 
                                    Màu: {{ $item->color->Color ?? 'Mặc định' }}
                                </p>
                                <div class="d-flex justify-content-between">
                                    <span class="text-danger fw-bold">{{ number_format($item->Price, 0, ',', '.') }}đ</span>
                                    <span class="text-muted">Số lượng: {{ $item->Quantity }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="payment-info mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">THANH TOÁN</h6>
                            <p><strong>Phương thức:</strong> 
                                {{ $order->PaymentMethod == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' }}
                            </p>
                            <p><strong>Trạng thái:</strong> 
                                <span class="badge bg-light text-dark">
                                    {{ $order->payments->first()->STATUS == 'completed' ? 'Đã thanh toán' : 'Chờ thanh toán' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h6 class="fw-bold mb-3">TỔNG CỘNG</h6>
                            <h2 class="text-white">{{ number_format($order->TotalAmount, 0, ',', '.') }}đ</h2>
                            <p class="small">Đã bao gồm VAT</p>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">TIẾN TRÌNH ĐƠN HÀNG</h6>
                        <div class="order-timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div>
                                    <h6 class="fw-bold text-success">Đặt hàng thành công</h6>
                                    <p class="text-muted small mb-0">{{ $order->OrderDate->format('d/m/Y H:i') }}</p>
                                    <p class="mb-0">Đơn hàng đã được tiếp nhận</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div>
                                    <h6 class="fw-bold">Xác nhận đơn hàng</h6>
                                    <p class="text-muted small mb-0">Dự kiến: {{ now()->addMinutes(30)->format('H:i') }}</p>
                                    <p class="mb-0">Nhân viên sẽ liên hệ xác nhận</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div>
                                    <h6 class="fw-bold">Đóng gói & Vận chuyển</h6>
                                    <p class="text-muted small mb-0">Dự kiến: {{ now()->addHours(2)->format('H:i') }}</p>
                                    <p class="mb-0">Chuẩn bị hàng và giao cho đơn vị vận chuyển</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div>
                                    <h6 class="fw-bold">Giao hàng thành công</h6>
                                    <p class="text-muted small mb-0">Dự kiến: 2-3 ngày làm việc</p>
                                    <p class="mb-0">Giao hàng tận nơi theo địa chỉ đã đăng ký</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons text-center">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="#" class="btn btn-outline-primary me-md-2">
                            <i class="fas fa-list me-2"></i>Xem lịch sử đơn hàng
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                        </a>
                        @if($order->PaymentMethod == 'bankTransfer' && $order->payments->first()->STATUS != 'completed')
                        <a href="#" class="btn btn-danger">
                            <i class="fas fa-credit-card me-2"></i>Thanh toán ngay
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Support Information -->
                <div class="text-center mt-4">
                    <p class="text-muted">
                        Cần hỗ trợ? Liên hệ hotline: 
                        <strong class="text-danger">1900.2091</strong> 
                        (7:30 - 22:00)
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-facebook-messenger text-primary me-1"></i> Messenger
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fas fa-phone-alt text-success me-1"></i> Gọi điện
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fas fa-envelope text-warning me-1"></i> Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Print order function
    window.printOrder = function() {
        window.print();
    }

    // Share order function
    window.shareOrder = function() {
        if (navigator.share) {
            navigator.share({
                title: 'Đơn hàng #{{ $order->OrderID }}',
                text: 'Tôi vừa đặt hàng thành công tại CellphoneS',
                url: window.location.href
            })
            .catch(console.error);
        } else {
            alert('Chức năng chia sẻ không được hỗ trợ trên trình duyệt này');
        }
    }
});
</script>
@endsection