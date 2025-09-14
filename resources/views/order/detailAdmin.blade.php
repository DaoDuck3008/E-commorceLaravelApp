@extends('admin.app')

@section('title')
    <title>Chi tiết đơn hàng</title>
@endsection

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
                <div class="mb-3 action-buttons">
                    <a href="{{ route('admin.order.dashboard') }}" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i> Trở lại</a>
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
                                    @switch($order->STATUS)
                                    @case('Pending')
                                        <span class="badge status-badge bg-warning">Chờ xác nhận</span>
                                        @break
                                    @case('Confirmed')
                                        <span class="badge status-badge bg-primary">Đã xác nhận</span>
                                        @break
                                    @case('Shipped')
                                        <span class="badge status-badge bg-info">Đang được giao</span>
                                        @break
                                    @case('Completed')
                                        <span class="badge status-badge bg-success">Đã hoàn thành</span>
                                        @break
                                    @case('Cancelled')
                                        <span class="badge status-badge bg-danger">Đã được hủy</span>
                                        @break
                                    @default
                                @endswitch
                                </p>
                                @if($order->CancelReason)
                                    <p><strong>Lý do hủy: </strong>{{ $order->CancelReason }}</p>
                                @endif
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
                        @if ($order->STATUS !== 'Cancelled')
                            <div class="order-timeline">
                                <div class="timeline-item">
                                    <div class="timeline-icon"></div>
                                    <div>
                                        <h6 class="fw-bold {{ $order->STATUS === 'Pending' ? 'text-success' : '' }}">Đặt hàng thành công</h6>
                                        <p class="text-muted small mb-0">{{ $order->OrderDate->format('d/m/Y H:i') }}</p>
                                        <p class="mb-0">Đơn hàng đã được tiếp nhận</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-icon"></div>
                                    <div>
                                        <h6 class="fw-bold {{ $order->STATUS === 'Confirmed' ? 'text-success' : '' }}">Xác nhận đơn hàng</h6>
                                        <p class="text-muted small mb-0">Dự kiến: {{ now()->addMinutes(30)->format('H:i') }}</p>
                                        <p class="mb-0">Nhân viên sẽ liên hệ xác nhận</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-icon"></div>
                                    <div>
                                        <h6 class="fw-bold {{ $order->STATUS === 'Shipped' ? 'text-success' : '' }}">Đóng gói & Vận chuyển</h6>
                                        <p class="text-muted small mb-0">Dự kiến: {{ now()->addHours(2)->format('H:i') }}</p>
                                        <p class="mb-0">Chuẩn bị hàng và giao cho đơn vị vận chuyển</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-icon"></div>
                                    <div>
                                        <h6 class="fw-bold {{ $order->STATUS === 'Completed' ? 'text-success' : '' }}">Giao hàng thành công</h6>
                                        <p class="text-muted small mb-0">Dự kiến: 2-3 ngày làm việc</p>
                                        <p class="mb-0">Giao hàng tận nơi theo địa chỉ đã đăng ký</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                    Trạng thái đơn hàng
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-danger">ĐƠN HÀNG ĐÃ HỦY</h5>
                                    <p class="card-text">{{ $order->CancelReason }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons text-center">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        {{-- Nếu đơn hàng đã bị hủy thì không thể chỉnh sửa nữa --}}
                        @if ($order->STATUS !== 'Cancelled' && $order->STATUS !== 'Completed')
                            <form action="{{ route('admin.order.updateStatus',$order->OrderID)}}" method="post" class="d-inline">
                                @csrf
                                @method('PUT')
                                    <button type="submit" class="btn btn-success me-md-2">
                                        <i class="fa-solid fa-file-pen me-2"></i>Cập nhật đơn hàng
                                    </button>
                            </form>
                        @endif
                       
                        {{-- Nếu đơn hàng chưa được xác nhận thì có thể hủy --}}
                        @if($order->STATUS === 'Pending' && $order->STATUS !== 'Cancelled')
                        <button type="button" class="btn btn-danger me-md-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                            <i class="fa-solid fa-trash me-2"></i>Hủy đơn hàng
                        </button>

                        <!-- Modal hủy đơn hàng -->
                        <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cancelOrderModalLabel">Hủy đơn hàng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.order.cancel', $order->OrderID) }}" method="post" id="cancelOrderForm">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="cancelReason" class="form-label"><h4 class="rounded p-3 bg-danger text-white">Lý do hủy đơn hàng</h4></label>
                                                <textarea class="form-control" id="cancelReason" name="reason" rows="3" required placeholder="Nhập lý do hủy đơn hàng..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
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

document.getElementById('cancelOrderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const reason = document.getElementById('cancelReason').value.trim();
    
    if (!reason) {
        alert('Vui lòng nhập lý do hủy đơn hàng');
        return;
    }
    
    if (confirm('Bạn có chắc muốn hủy đơn hàng này không?')) {
        this.submit();
    }
});
</script>
@endsection