<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng ký SMEMBER</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      body {
        background-color: #fff;
        padding-bottom: 500px;
      }

      .register-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
      }

      .register-container h1 {
        color: #b22222;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
      }

      .section-title {
        font-weight: 700;
        font-size: 1.25rem;
        margin: 20px 0 15px;
        color: #333;
      }

      .social-btn {
        border: 1px solid #ccc;
        background: #fff;
        padding: 10px;
        border-radius: 6px;
        width: 48%;
        text-align: center;
        font-weight: 500;
        cursor: pointer;
      }

      .social-btn img {
        height: 20px;
        margin-right: 8px;
      }

      .btn-primary-custom {
        background-color: #b22222;
        border: none;
      }

      .btn-primary-custom:hover {
        background-color: #a11e1e;
      }

      .form-control:focus {
        border-color: #b22222;
        box-shadow: none;
      }

      .divider {
        border-top: 2px solid #ddd;
        margin: 30px 0;
      }

      .footer-fixed {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        border-top: 1px solid #ddd;
        padding: 20px 20px;
        display: flex;
        justify-content: center;
        gap: 20px;
        z-index: 1000;
      }

      .footer-fixed .btn {
        min-width: 700px;
        font-size: 16px;
        font-weight: 650;
        padding: 10px 20px;
      }
    </style>
  </head>

  <body>
    <div class="register-container">
      <div style="position: fixed; top:0 ; right:0; z-index:100">
        @include('components.notice')
      </div>
      <a href="{{ url('/') }}" class="btn btn-link text-decoration-none d-flex align-items-center mb-3" style="color: #b22222">
        <h5 class="ms-1"> Về Trang chủ</h5>
      </a>
      <h1>Đăng ký trở thành SMEMBER</h1>
      <form class="mt-5" method="POST" action="/register">
        @csrf
        <h2 class="section-title">Thông tin cá nhân</h2>
        <div class="row">
          <div class="col-md-12 mb-3">
            <!-- NAME -->
            <label class="form-label">Họ và tên:</label>
            <input
              type="text"
              class="form-control @error('name') is-invalid @enderror"
              placeholder="Nhập họ và tên"
              name="name"
              value="{{ old('name') }}"
              required
            />
            @error('name')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="row">
          <!-- PHONE -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Số điện thoại:</label>
            <input
              type="text"
              class="form-control  @error('phone') is-invalid @enderror"
              placeholder="Nhập số điện thoại"
              value="{{ old('phone') }}"
              name="phone"
              required
            />
            @error('phone')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>
          <!-- EMAIL -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Email:</label>
            <input
              type="email"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="Nhập email"
              name="email"
              value="{{ old('email') }}"
              required
            />
            @error('email')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="divider"></div>

        <h2 class="section-title">Tạo mật khẩu</h2>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Mật khẩu:</label>
            <input
              type="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="Nhập mật khẩu"
              name="password"
              required
            />
            <small class="text-muted"
              >Mật khẩu tối thiểu 6 ký tự, có ít nhất 1 chữ cái và 1 số</small
            >
            @error('password')
              <span class="text-danger small">{{ $message }}</span>
            @enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Nhập lại mật khẩu:</label>
            <input
              type="password"
              class="form-control"
              placeholder="Nhập lại mật khẩu"
              name="password_confirmation"
              required
            />
          </div>
        </div>

        <div class="footer-fixed">
          <a href="{{ route('login') }}" class="btn btn-outline-secondary">
            Quay lại đăng nhập</a
          >
          <button type="submit" class="btn btn-primary-custom text-white">
            Hoàn tất đăng ký
          </button>
        </div>
      </form>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
