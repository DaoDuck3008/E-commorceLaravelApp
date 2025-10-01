@extends('layouts.appWithoutFooter')

@section('style')
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Custom container */
        .custom-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* Payment tabs */
        .payment-tabs {
            background: white;
            border-radius: 25px;
            padding: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .payment-tab {
            border: none;
            background: transparent;
            padding: 12px 30px;
            border-radius: 20px;
            font-weight: 500;
            color: #666;
            transition: all 0.3s ease;
        }
        
        .payment-tab.active {
            background: #dc3545;
            color: white;
        }
        
        .tab-number {
            font-weight: bold;
            margin-right: 5px;
        }
        
        /* Product image */
        .product-image-small {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        
        .product-name-small {
            font-size: 14px;
            line-height: 1.3;
            margin-bottom: 8px;
        }
        
        /* Cards */
        .card {
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important;
            border-radius: 12px !important;
        }
        
        .card h6 {
            color: #333;
            font-size: 16px;
        }
        
        /* Badge */
        .badge {
            font-size: 10px;
            padding: 4px 8px;
        }
        
        /* Form elements */
        .form-select, .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
        }
        
        .form-select:focus, .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
        }
        
        /* Price styling */
        .price-current {
            color: #dc3545;
            font-weight: bold;
            font-size: 18px;
        }
        
        .price-original {
            color: #999;
            text-decoration: line-through;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .custom-container {
                padding: 0 10px;
            }
            
            .payment-tab {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
        
        /* Icon animations */
        .fas, .fab, .far {
            transition: all 0.3s ease;
        }
        
        .card:hover .fas,
        .card:hover .fab,
        .card:hover .far {
            transform: scale(1.1);
        }
        
        /* Badge improvements */
        .badge {
            font-size: 11px;
            padding: 5px 10px;
            border-radius: 12px;
        }
        
        /* Alert styling */
        .alert {
            border: none;
            border-left: 4px solid #0dcaf0;
        }
        
        /* Button icon animation */
        .btn:hover .fas {
            animation: bounce 0.5s ease-in-out;
        }
        
        @keyframes bounce {
            0%, 20%, 60%, 100% { transform: translateY(0); }
            40% { transform: translateY(-5px); }
            80% { transform: translateY(-2px); }
        }
        
        /* Form icon styling */
        .form-label .fas,
        .form-label .far {
            width: 20px;
            text-align: center;
        }
    </style> 
@endsection

@section('content')
    <main class=" min-vh-100">
        <div class="py-3">
            <div class="custom-container d-flex align-items-center">
                <a href="{{ route('cart.index') }}" class="text-dark me-3 d-flex gap-2 text-decoration-none">
                    <i class="fa-solid fa-arrow-left fs-5"></i>
                    <h5 class="mb-0 fw-bold">Trở lại</h5>
                </a>
            </div>
        </div>

        {{-- Thông tin nhận hàng --}}
        <div class="custom-container">
            {{-- Thông tin sản phẩm --}}
            <div class="card p-4 mb-4">
                <h6 class="mb-3 fw-bold">THÔNG TIN SẢN PHẨM</h6>
                @foreach ( $cartItems as $item )
                @php
                    $itemPrice = $item->version->Price ?? $item->product->Price;
                    $itemAmount = $itemPrice * $item->Quantity;
                @endphp
                    <div class="d-flex align-items-center my-2">
                        <img
                            src="{{ $item->product->ImageURL }}"
                            alt="{{ $item->product->ProductName }}"
                            class="product-image-small me-3"
                        />
                        <div class="flex-grow-1">
                            <h6 class="mb-2 product-name-small">
                                {{ $item->product->ProductName }}
                            </h6>
                            <h6 class="mb-2 product-name-small">
                                Phiên bản: {{ $item->version->VersionName ?? 'Mặc định' }} - Màu sắc: {{ $item->color->Color ?? 'Mặc định'}}
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                <span class="price-current">{{ number_format($itemPrice, 0, ',', '.') }}đ</span>
                                <span class="price-original">{{ number_format($itemPrice + 1000000, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                        <div class="text-end d-flex flex-column gap-2">
                            <span class="text-secondary small">Số lượng: {{ $item->Quantity }}</span>
                            <h6 class="total-amount text-danger" id="item-total" data-price={{ $itemAmount }} style="font-weight:700">Tổng giá: {{ number_format($itemAmount, 0, ',', '.') }}đ</h6>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Thông tin khách hàng --}}
            <div class="card p-4 mb-4">
                <h6 class="mb-3 fw-bold">THÔNG TIN KHÁCH HÀNG</h6>
                @php
                    $user = auth()->user();
                @endphp
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <span class="fw-bold me-2">{{ $user->FullName }}</span>
                        <span class="badge bg-danger">S-{{ $user->Role }}</span>
                    </div>
                    <span class="fw-medium">Liên hệ: {{ $user->PhoneNumber }}</span>
                </div>
                <div class="mb-3">
                    <label class="form-label">EMAIL</label>
                    <div class="fw-medium">{{ $user->Email}}</div>
                </div>
                <p class="text-muted small mb-3">
                    (*) Hóa đơn VAT sẽ được gửi qua email này
                </p>
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="receive-email"
                    />
                    <label class="form-check-label text-secondary" for="receive-email">
                        Nhận email thông báo và ưu đãi từ CellphoneS
                    </label>
                </div>
            </div>

            <form action="{{ $buyNow === true ? route('processCheckoutBuyNow',['selectedIds' => $selectedIds,'cartID' => $cartItems->first()->CartID]) : route('processCheckout',['selectedIds' => $selectedIds]) }}" method="post" id="checkout-form">
            @csrf
                {{-- Thông tin giao hàng --}}
                <div class="card p-4 mb-4">
                    <h6 class="mb-3 fw-bold">THÔNG TIN NHẬN HÀNG</h6>
                    
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">TỈNH / THÀNH PHỐ</label>
                                <input class="form-control" type="text" name="city" required placeholder="Hà Nội"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">QUẬN/HUYỆN</label>
                                <input class="form-control" type="text" name="district" required placeholder="Quận Cầu Giấy"/>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">ĐỊA CHỈ CỤ THỂ</label>
                            <textarea class="form-control" rows="2" name="address" placeholder="Số 5, ngõ 81, đường Đông Ngạc, Bắc Từ Liêm, Hà Nội" required></textarea>
                        </div>
        
                        <div class="mb-4">
                            <label class="form-label">SỐ ĐIỆN THOẠI LIÊN HỆ NHẬN HÀNG</label>
                            <input class="form-control" type="text" name="phoneNumber" required />
                            <i class="mt-2">Nếu bạn không điền phần này chúng tôi sẽ hiểu là số điện thoại đăng kí tài khoản của bạn.</i>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">GHI CHÚ KHÁC (nếu có)</label>
                            <textarea class="form-control" rows="3" name="description" placeholder="Nhập ghi chú của bạn..."></textarea>
                        </div>
        
                        <hr class="my-4" />
                        
                        <h6 class="mb-3 fw-bold">
                            Quý khách có muốn xuất hóa đơn công ty không?
                        </h6>
                        <div class="d-flex">
                            <div class="form-check me-4">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="vat-invoice"
                                    id="vat-yes"
                                />
                                <label class="form-check-label fw-medium" for="vat-yes">Có</label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="vat-invoice"
                                    id="vat-no"
                                    checked
                                />
                                <label class="form-check-label fw-medium" for="vat-no">Không</label>
                            </div>
                        </div>

                        
                </div>

                {{-- Phương thức thanh toáns --}}
                <div class="">
                    <!-- Card 1: Mã giảm giá -->
                    <div class="card p-4 mb-4">
                        <h6 class="mb-3 fw-bold">MÃ GIẢM GIÁ</h6>
                        
                        <div class="mb-4">
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Nhập mã giảm giá (chỉ áp dụng 1 lần)"
                                    aria-label="Mã giảm giá"
                                >
                                <button class="btn btn-danger" type="button">Áp dụng</button>
                            </div>
                        </div>

                        

                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Số lượng sản phẩm</span>
                                    <span class="fw-medium">01</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tổng tiền hàng</span>
                                    <span class="fw-medium" id="total"></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Phí vận chuyển</span>
                                    <span class="text-success fw-medium">Miễn phí</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Giảm giá trực tiếp</span>
                                    <span class="text-danger fw-medium">- 0đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Chiết khấu Smember [ <strong>S-MEM</strong> ]</span>
                                    <span class="text-danger fw-medium">- 0đ</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">Tổng tiền</span>
                                    <span class="text-danger fw-bold fs-5" id="total2"></span>
                                </div>
                            </div>
                        </div>

                        <p class="text-muted small mb-0 mt-3">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Đã gồm VAT và được làm tròn
                        </p>
                    </div>

                    <!-- Card 2: Thông tin thanh toán -->
                    <div class="card p-4 mb-4">
                        <h6 class="mb-3 fw-bold">THÔNG TIN THANH TOÁN</h6>
                        
                        <div class="mb-3">
                            <h6 class="text-dark mb-2">Chọn phương thức thanh toán</h6>
                            <p class="text-success small mb-3">
                                <i class="fa-solid fa-tag me-1"></i>
                                Giảm thêm tới 1.000.000đ
                            </p>
                            
                            <div class="payment-methods">
                                <!-- Phương thức COD -->
                                <div class="form-check payment-method-item mb-3">
                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        name="paymentMethod" 
                                        id="cod" 
                                        value="cod"
                                        checked
                                    >
                                    <label class="form-check-label w-100" for="cod">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 fw-medium">Thanh toán khi nhận hàng (COD)</h6>
                                                <p class="text-muted small mb-0">Nhận hàng và thanh toán trực tiếp</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-success">Miễn phí</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Phương thức Chuyển khoản ngân hàng -->
                                <div class="form-check payment-method-item mb-3">
                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        name="paymentMethod" 
                                        id="bankTransfer" 
                                        value="bankTransfer"
                                    >
                                    <label class="form-check-label w-100" for="bankTransfer">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 fw-medium">Chuyển khoản ngân hàng</h6>
                                                <p class="text-muted small mb-0">Thanh toán qua Internet Banking</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-success">Miễn phí</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <div class="custom-container">
        <div class="">
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary fw-medium fs-6">Tổng tiền tạm tính:</span>
                    <span class="text-danger fw-bold fs-4" id="total3">đ</span>
                </div>
                <div class="d-grid">
                    <button class="btn btn-danger btn-lg py-3 fw-bold" type="submit" form="checkout-form">
                        THANH TOÁN
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalAmount = document.getElementById('total');
            const totalAmount2 = document.getElementById('total2');
            const totalAmount3 = document.getElementById('total3');
            const itemsAmount = document.querySelectorAll('#item-total');

            let total = 0;
            itemsAmount.forEach(item => {
                total += parseFloat(item.dataset.price);
            });

            totalAmount.textContent = formatCurrency(total) + 'đ';
            totalAmount2.textContent = formatCurrency(total) + 'đ';
            totalAmount3.textContent = formatCurrency(total) + 'đ';

            function formatCurrency(amount) {
                return amount.toLocaleString('vi-VN');
            }
        });
    </script>
@endsection