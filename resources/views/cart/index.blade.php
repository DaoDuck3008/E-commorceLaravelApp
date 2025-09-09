@extends('layouts.appWithoutFooter')

@section('content')
    <main class="bg-light min-vh-100 pb-5">
        <div class="custom-container mt-4">
        <div class="container tab-cart-type mt-3 d-flex justify-content-between align-items-center">
            <button class="tab-item active btn border rounded">Giỏ hàng</button>
            <div class="form-check d-flex align-items-center">
            <input
                class="form-check-input mt-0"
                type="radio"
                name="select-all"
                id="select-all"
            />
            <label class="form-check-label ms-2" for="select-all">
                Chọn tất cả
            </label>
            </div>
        </div>

        <div class="card p-3 shadow-sm rounded-3 mb-3 border-0">
            <div class="d-flex align-items-start">
            <div class="form-check me-3 mt-1">
                <input
                class="form-check-input"
                type="checkbox"
                value=""
                id="product-1"
                />
                <label class="form-check-label" for="product-1"></label>
            </div>

            <img
                src="/Images/gioHang/macbook.webp"
                alt="MacBook Pro"
                class="product-image me-3"
            />

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                <div>
                    <h6 class="product-name fw-semibold text-dark">
                    MacBook Pro 14 M4 10CPU 10GPU 24GB <br />512GB | Chính hãng
                    Apple Việt Nam-Bạc
                    </h6>
                    <span class="product-price text-danger fw-bold me-2">43.290.000đ</span>
                    <span class="product-old-price text-muted text-decoration-line-through">44.990.000đ</span>
                </div>
                <i class="fa-solid fa-trash-can text-secondary fs-5 cursor-pointer"></i>
                </div>
                <div class="d-flex justify-content-end align-items-center mt-2">
                <span class="text-danger me-3 small">Đã giảm 500.000đ S.Student</span>
                <div class="input-group quantity-control ms-auto border rounded">
                    <button class="btn btn-outline-secondary border-0" type="button">-</button>
                    <input type="text" class="form-control text-center border-0" value="1" />
                    <button class="btn btn-outline-secondary border-0" type="button">+</button>
                </div>
                </div>
            </div>
            </div>

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
        </div>
    </main>

    <div class="fixed-checkout-bar">
        <div class="container">
        <div class="card p-2 p-md-3 rounded-3 border-0">
            <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row gap-3">
            <div class="d-flex flex-column text-center text-sm-start">
                <div class="mb-1">
                <span class="text-secondary">Tạm tính: </span>
                <span class="text-danger fw-bold fs-5 fs-md-4">43.290.000đ</span>
                </div>
                <div class="d-flex justify-content-center justify-content-sm-start">
                <span class="text-secondary small me-2">Tiết kiệm: </span>
                <span class="text-primary fw-bold small">1.700.000đ</span>
                </div>
            </div>
            <button class="btn btn-danger btn-lg rounded-pill px-3 px-md-4 w-100 w-sm-auto" style="min-width: 200px; max-width: 250px;">
                Mua ngay (1)
            </button>
            </div>
        </div>
        </div>
    </div>
@endsection