<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @yield('title')
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

     <!-- Font Awesome CSS -->
     <link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
   />
    <!-- HomePage CSS -->
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fc;
      }
      .sidebar {
        height: 100vh;
        background-color: #ffffff; /* CellphoneS red */
        padding-top: 20px;
        position: fixed;
        left: 0;
        top: 0;
        width: 240px;
      }
      .sidebar a {
        color: black;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 5px;
      }
      .sidebar a:hover,
      .sidebar a.active {
        background-color: #da2e42;
        color: white;
        font-weight: 500;
      }
      .main-content {
        margin-left: 240px;
        padding: 20px;
      }
      .topbar {
        display: flex;
        background: white;
        padding: 10px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      }
      .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 20px;
        background: white;
      }
    </style>

    @yield('style')

    @vite('resources/scss/dashboard.scss')
  </head>

  <div style="position: fixed; top: 0; right:0">
    @include('components.notice')
  </div>

  <body>
    <!-- Sidebar -->
    <div class="sidebar shadow rounded d-flex flex-column justify-content-between">
      <div>
        <h4 class="px-3 mb-4">Dashboard</h4>
        <a href="/admin" class="{{ request()->is('admin/products*') || request()->is('admin') ? 'active' : '' }}"><i class="fa-solid fa-window-restore me-2"></i> Quản lý sản phẩm</a>
        <a href="/admin/category" class="{{ request()->is('admin/category*') ? 'active' : '' }}"><i class="fa-solid fa-layer-group me-2"></i> Quản lý danh mục</a>
        <a href="/admin/brand" class="{{ request()->is('admin/brand*') ? 'active' : '' }}"><i class="fa-solid fa-copyright me-2"></i> Quản lý thương hiệu </a>
        <a href="/admin/user" class="{{ request()->is('admin/user*') ? 'active' : '' }}"><i class="fa-solid fa-users me-2"></i> Quản lý người dùng</a>
        <a href="{{ route('admin.order.dashboard') }}" class="{{ request()->is('admin/order*') ? 'active' : '' }}"><i class="fa-solid fa-truck-moving me-2"></i> Quản lý đơn hàng</a>
        <a href="/admin/promotion" class="{{ request()->is('admin/promotion*') ? 'active' : '' }}"><i class="fa-solid fa-ticket me-2"></i> Quản lý khuyến mãi</a>

      </div>
      
      <div>
        @auth
        <a
          aria-current="page"
          class="btn btn-dark m-1"
          href="logout"
          style="color: white"
          ><i class="fa-solid fa-user me-1"></i>{{ auth()->user()->FullName }} | {{ auth()->user()->Role }}</a>
        @endauth
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      @yield('content')
    </div>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('script')
  </body>
</html>
