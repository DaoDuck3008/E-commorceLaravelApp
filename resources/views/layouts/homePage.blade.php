<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>

    <!-- Bootstrap -->
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
    @vite('resources/scss/app.scss')
    
    @vite('resources/scss/product.scss')

    @yield('style')
</head>
<body>
    {{-- Header --}}
    <header>
      @include('layouts.header')
    </header>

    <div style="position: fixed; top:0 ; right:0; z-index:100">
      @include('components.notice')
    </div>

    {{-- body --}}
    <main class="container my-2" >
      <div class="ads-container row mt-2 ">
        <!-- Sidebar ở bên trái -->
        @include('components.sidebar')

        <!-- Quảng cáo ở chính giữa -->
        @include('components.mainAds')

        <!-- Quảng cáo nhỏ ở bên phải -->
        @include('components.smallAds')
      </div>

      <!-- Quảng cáo dài  -->
      <div class="long-ads mt-3">
        <img src="{{ asset('storage/staticAds/longAds.gif') }}" />
      </div>

      {{-- Gợi ý sản phẩm --}}
      <div>
        @include('components.recommendProducts')
      </div>
  
      @yield('content')
      
    </main>

    {{-- Footer --}}
    <footer class="mt-3" style="background-color: #212b2b; color: white">
      @include('layouts.footer')
    </footer>

    <!-- Nút lên đầu trang -->
    <button
    id="backToTop"
    class="d-none d-md-block btn btn-dark shadow d-flex align-items-center justify-content-center"
    style="
      display: none;
      position: fixed;
      bottom: 80px;
      right: 20px;
      z-index: 1030;
      font-size: large;
    "
    >
      <strong>Lên đầu</strong
      ><i class="fa-solid fa-up-long ms-1" style="color: #fcfcfd"></i>
    </button>

    <!-- Nút mở khung chat -->
    <button
      class="btn shadow d-none d-md-block"
      style="
        background-color: #db2f17;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
        color: white;
        font-size: large;
      "
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#chatCollapse"
      aria-expanded="false"
      aria-controls="chatCollapse"
    >
      <strong>Tư vấn</strong><i class="fa-regular fa-comments ms-1"></i>
    </button>

    <!-- Khung Chat  -->
    <div
      class="collapse position-fixed end-0 p-3"
      id="chatCollapse"
      style="width: 300px; bottom: 80px; z-index: 1040"
    >
      <div class="card shadow" style="height: 400px">
        <div
          class="card-header text-white d-flex"
          style="background-color: #db2f17"
        >
          <h4 class="mt-1 me-auto">Hỗ trợ trực tuyến</h4>
          <button
            type="button"
            class="btn-close mt-2"
            aria-label="Close"
            data-bs-toggle="collapse"
            data-bs-target="#chatCollapse"
            aria-controls="chatCollapse"
          ></button>
        </div>
        <div class="card-body overflow-auto">
          <p class="text-muted small">
            Xin chào! Chúng tôi có thể giúp gì cho bạn?
          </p>
        </div>
        <div class="card-footer">
          <div class="input-group">
            <input
              type="text"
              class="form-control"
              placeholder="Nhập tin nhắn..."
            />
            <button class="btn" style="background-color: #db2f17; color: white">
              <strong>Gửi</strong>
            </button>
          </div>
        </div>
      </div>
    </div>
  
  
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Back to top
      const btn = document.getElementById("backToTop");

      window.addEventListener("scroll", () => {
        if (window.scrollY > 100) {
          btn.style.display = "flex";
        } else {
          btn.style.display = "none";
        }
      });

      btn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
      });
    </script>

    @yield('script')

  </body>
</html>