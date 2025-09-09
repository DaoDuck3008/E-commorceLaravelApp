<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tri ân khách hàng</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />
    <style>
      body {
        background-color: #f8f9fa;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }

      .sidebar {
        min-height: 100vh;
        background-color: #fff;
        border-right: 1px solid #e0e0e0;
        box-shadow: 2px 0 6px rgba(0, 0, 0, 0.05);
        border-radius: 0 20px 20px 0; /* bo tròn góc */
      }
      .sidebar .nav-link {
        color: #555;
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      .sidebar .nav-link:last-child {
        border-bottom: none;
      }
      .sidebar .nav-link:hover {
        background-color: #f1f1f1;
        color: #e63946;
      }
      .sidebar .nav-link.active {
        background-color: #ffeaea;
        color: #e63946;
        font-weight: 600;
      }

      .card-custom {
        border: none;
        border-radius: 20px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
      }
      .order-item {
        border-bottom: 1px solid #eee;
        padding: 12px 0;
      }
      .order-item:last-child {
        border-bottom: none;
      }

      .quick-access {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
      }
      .quick-access .item {
        background: #fef2f2;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        transition: 0.3s;
        cursor: pointer;
      }
      .quick-access .item:hover {
        background: #ffeaea;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
      }
      .quick-access i {
        font-size: 24px;
        color: #e63946;
        margin-bottom: 8px;
      }
    </style>
  </head>

  <body>
    <div style="position: fixed; top:0 ; right:0; z-index:100">
        @include('components.notice')
    </div>
    
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar p-4 d-flex flex-column justify-content-between">
          <nav class="nav flex-column d-flex ">
            <h1 class="mb-4 text-danger fw-bold">Smember</h1>
            <a class="nav-link {{ request()->is('user/overall*') ? 'active' : '' }}" href="/user/overall/{{ auth()->user()->UserID }}"
              ><i class="bi bi-speedometer2"></i> Tổng quan</a
            >
            <a class="nav-link" href="#"
              ><i class="bi bi-bag-check"></i> Lịch sử mua hàng</a
            >
            <a class="nav-link" href="#"
              ><i class="bi bi-mortarboard"></i> Ưu đãi S-Student & S-Teacher</a
            >
            <a class="nav-link {{ request()->is('user/profile*') ? 'active' : '' }}" href="/user/profile/{{ auth()->user()->UserID }}"
              ><i class="bi bi-person"></i> Thông tin tài khoản</a
            >
            <a class="nav-link" href="#"
              ><i class="bi bi-geo-alt"></i> Tìm kiếm cửa hàng</a
            >
          </nav>

          <div class="d-flex flex-column gap-2">
            <a href="/" class="btn btn-dark">Về trang chủ</a>
            <a href="/logout" class="btn btn-danger">Đăng xuất</a>
          </div>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            @yield('content')
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
