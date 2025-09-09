@extends('layouts.profileLayout')

@section('content')
  <!-- Header user info -->
  <div
    class="card-custom d-flex flex-column flex-md-row justify-content-between align-items-center gap-3"
  >
    <div class="d-flex align-items-center gap-3">
      <!-- Avatar -->
      <img
        src="https://anhcute.net/wp-content/uploads/2024/08/Hinh-anh-chibi-chuot-lang-nuoc-ngoi-thien.jpg"
        alt="Avatar"
        class="rounded-circle"
        width="70"
        height="70"
      />
      <div>
        <h5 class="fw-bold mb-1">{{ $user->FullName }}</h5>
        <span class="badge bg-danger me-1">S-MEM</span>
        <span class="badge bg-success">{{ $user->Role }}</span>
        <p class="mb-0 text-muted">Cập nhật lại sau 01/01/2026</p>
      </div>
    </div>
    <div class="text-center text-md-end">
      <h6 class="mb-1">Tổng số đơn đã mua: <strong>1</strong></h6>
      <h6 class="mb-0">
        Tổng tiền tích lũy:
        <strong class="text-danger">17.942.000đ</strong>
      </h6>
    </div>
  </div>

  <div class="card-custom quick-access">
    <div class="item">
      <i class="bi bi-star-fill"></i>
      <p class="mb-0 fw-semibold">Hạng thành viên</p>
    </div>
    <div class="item">
      <i class="bi bi-ticket-perforated"></i>
      <p class="mb-0 fw-semibold">Mã giảm giá</p>
    </div>
    <div class="item">
      <i class="bi bi-bag-check-fill"></i>
      <p class="mb-0 fw-semibold">Lịch sử mua hàng</p>
    </div>
    <div class="item">
      <i class="bi bi-geo-alt-fill"></i>
      <p class="mb-0 fw-semibold">Sổ địa chỉ</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card-custom">
        <h6 class="fw-bold mb-3">
          <i class="bi bi-box-seam"></i> Đơn hàng gần đây
        </h6>
        <div class="order-item">
          <strong>Đơn hàng #024342S2408000131</strong> - 03/08/2024
          <p class="mb-1">
            Laptop Lenovo LOQ i5-12450HX / 12GB / 512GB / VGA 4GB
          </p>
          <span class="badge bg-success">Đã nhận hàng</span>
          <span class="float-end fw-bold text-danger">17.942.000đ</span>
        </div>
        <div class="order-item">
          <strong>Đơn hàng #024342S2408000131</strong> - 03/08/2024
          <p class="mb-1">
            Laptop Lenovo LOQ i5-12450HX / 12GB / 512GB / VGA 4GB
          </p>
          <span class="badge bg-warning text-dark">Đã xác nhận</span>
          <span class="float-end fw-bold text-danger">17.942.000đ</span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-custom text-center">
        <img
          src="https://cdn-icons-png.flaticon.com/512/992/992651.png"
          class="img-fluid mb-3"
          width="80"
        />
        <p class="mb-2 text-muted">Bạn chưa có ưu đãi nào.</p>
        <a href="#" class="btn btn-outline-danger btn-sm px-3"
          >Xem sản phẩm</a
        >
      </div>
    </div>
  </div>
@endsection