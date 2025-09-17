@extends('layouts.appWithoutFooter')

@section('content')
<main class="bg-light min-vh-100 pb-5">
    <div class="custom-container mt-4">
        <!-- Select All Checkbox -->
        <div class="container tab-cart-type my-3 d-flex flex-row-reverse align-items-center">
            <div class="form-check d-flex align-items-center">
                <input class="form-check-input mt-0" type="checkbox" name="select-all" id="select-all" />
                <label class="form-check-label ms-2" for="select-all">
                    <strong>Chọn tất cả</strong>
                </label>
            </div>
        </div>

        <!-- Cart Items -->
        @foreach ($cartitems as $index => $item)
        @php
            $itemPrice = $item->version->Price ?? $item->product->Price;
            $itemTotal = $itemPrice * $item->Quantity;
        @endphp
        <div class="card p-3 shadow-sm rounded-3 mb-3 border-0 cart-item" data-item-id="{{ $item->CartItemID }}" data-price="{{ $itemPrice }}" data-quantity="{{ $item->Quantity }}">
            <div class="d-flex align-items-start">
                <div class="form-check me-3 mt-1">
                    <input class="form-check-input item-checkbox" type="checkbox" value="{{ $item->CartItemID }}" 
                           id="product-{{ $index }}" data-price="{{ $itemTotal }}" />
                    <label class="form-check-label" for="product-{{ $index }}"></label>
                </div>

                <img src="{{ $item->product->ImageURL }}" alt="{{ $item->product->ProductName }}" class="product-image me-3" />

                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            <a href="/products/{{ $item->ProductID }}" class="product-name fw-semibold text-dark" style="text-decoration: none; font-weight: 600">
                                {{ $item->product->ProductName }} 
                                <br />
                                Phiên bản: {{ $item->version->VersionName ?? 'Mặc định' }} - Màu sắc: {{ $item->color->Color ?? 'Mặc định' }}
                            </a>
                            <span class="product-price text-danger fw-bold me-2">{{ number_format($itemPrice, 0, ',', '.') }}đ</span>
                            <span class="product-old-price text-muted text-decoration-line-through">{{ number_format($itemPrice + 1000000, 0, ',', '.') }}đ</span>
                        </div>
                        <form action="{{ route('cart.remove', $item->CartItemID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 border-0">
                                <i class="fa-solid fa-trash-can text-secondary fs-5 cursor-pointer"></i>
                            </button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-2">
                        <span class="text-danger me-3 small">Đã giảm 1.000.000đ S.Student</span>
                        <div class="input-group quantity-control ms-auto border rounded">
                            <form action="{{ route('cart.decrease', $item->CartItemID) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-secondary border-0" type="submit">-</button>
                            </form>
                            <span class="btn border-0 w-auto">{{ $item->Quantity }}</span>
                            <form action="{{ route('cart.increase', $item->CartItemID) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-secondary border-0" type="submit">+</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Các phần khuyến mại khác giữ nguyên -->
        {{-- Khuyến mại --}}
        <div class="mt-3 discount-section border rounded">
            <h6 class="discount-title text-dark">
                <i class="fa-solid fa-gift text-danger me-2"></i>Khuyến mãi hấp dẫn
            </h6>
            <ul class="list-unstyled discount-list">
                <li class="d-flex align-items-start">
                    <i class="fa-solid fa-circle text-danger me-2"></i>
                    Tặng combo 3 voucher tổng trị giá đến 2 triệu mua các sản phẩm túi, gia dụng, đồng hồ trẻ em
                </li>
                <li class="d-flex align-items-start">
                    <i class="fa-solid fa-circle text-danger me-2"></i>
                    Đặc quyền trợ giá lên đến 3 triệu khi thu cũ lên đời Macbook
                </li>
                <li class="d-flex align-items-start">
                    <i class="fa-solid fa-circle text-danger me-2"></i>
                    Giảm ngay 500K khi thanh toán qua thẻ tín dụng HSBC
                </li>
            </ul>
        </div>

        {{-- Bảo vệ toàn diện --}}
        <div class="d-flex justify-content-between flex-column flex-sm-row align-items-start align-items-sm-center border-top pt-3 mt-3 gap-2">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-shield-halved text-success me-2"></i>
                <span class="text-secondary small">Bảo vệ toàn diện, với Bảo hành mở rộng</span>
            </div>
            <a href="#" class="text-decoration-none text-danger fw-semibold">
                chọn gói <i class="fa-solid fa-chevron-right ms-1"></i>
            </a>
        </div>
    </div>
</main>

{{-- Tổng --}}
<div class="fixed-checkout-bar">
    <div class="container">
        <div class="card p-2 p-md-3 rounded-3 border-0">
            <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row gap-3">
                <div class="d-flex flex-column text-center text-sm-start">
                    <div class="mb-1">
                        <span class="text-secondary">Tạm tính: </span>
                        <span class="text-danger fw-bold fs-5 fs-md-4" id="selected-total">0đ</span>
                    </div>
                    <div class="d-flex justify-content-center justify-content-sm-start">
                        <span class="text-secondary small me-2">Tiết kiệm: </span>
                        <span class="text-primary fw-bold small">1.700.000đ</span>
                    </div>
                </div>
                <button class="btn btn-danger btn-lg rounded-pill px-3 px-md-4 w-100 w-sm-auto" 
                        style="min-width: 200px; max-width: 250px;" id="checkout-btn">
                    Mua ngay (<span id="selected-count">0</span>)
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const selectedTotalElement = document.getElementById('selected-total');
    const selectedCountElement = document.getElementById('selected-count');
    const checkoutBtn = document.getElementById('checkout-btn');

    // Khôi phục trạng thái từ sessionStorage
    function restoreSelectionState() {
        const savedSelection = sessionStorage.getItem('cartSelection');
        if (savedSelection) {
            const selectedItems = JSON.parse(savedSelection);
            
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = selectedItems.includes(checkbox.value);
            });
            
            updateSelectedTotal();
        }
    }

    // Lưu trạng thái vào sessionStorage
    function saveSelectionState() {
        const selectedItems = [];
        itemCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedItems.push(checkbox.value);
            }
        });
        sessionStorage.setItem('cartSelection', JSON.stringify(selectedItems));
    }

    // Cập nhật tổng tiền và số lượng
    function updateSelectedTotal() {
        let total = 0;
        let count = 0;
        const selectedItems = [];

        itemCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price);
                total += price;
                count++;
                selectedItems.push(checkbox.value);
            }
        });

        // Cập nhật UI
        selectedTotalElement.textContent = formatCurrency(total) + 'đ';
        selectedCountElement.textContent = count;
        checkoutBtn.disabled = count === 0;
        
        // Cập nhật trạng thái select all
        updateSelectAllState();
        
        // Lưu trạng thái
        saveSelectionState();
    }

    // Định dạng tiền tệ
    function formatCurrency(amount) {
        return amount.toLocaleString('vi-VN');
    }

    // Cập nhật trạng thái select all
    function updateSelectAllState() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        selectAllCheckbox.checked = checkedCount === itemCheckboxes.length && itemCheckboxes.length > 0;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < itemCheckboxes.length;
    }

    // Xử lý chọn tất cả
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateSelectedTotal();
    });

    // Xử lý chọn từng item
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedTotal);
    });

    // Xử lý nút thanh toán
     checkoutBtn.addEventListener('click', function() {
        const selectedItems = JSON.parse(sessionStorage.getItem('cartSelection') || '[]');
        if (selectedItems.length > 0) {
            // Chuyển đến trang thanh toán
            window.location.href = `/checkout?items=${selectedItems.join(',')}`;
        }
    });
    

    // Khôi phục trạng thái khi trang load
    restoreSelectionState();
    
    // Xử lý sự kiện pageshow cho browser back/forward
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Trang được load từ bfcache (back/forward)
            restoreSelectionState();
        }
    });
});
</script>
@endsection
