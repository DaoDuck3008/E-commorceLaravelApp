<div class="header-container" 
    style="position: sticky;
    top: 0;
    left: 0;
    z-index: 3;">
  <nav class="navbar navbar-expand-lg container" style="max-height: 80px">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">
        <img style="max-width: 160px; max-height: 80px" class="mx-2" src="{{ asset('storage/Logo.png') }}" />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse row"
        id="navbarSupportedContent"
      >
        <ul class="navbar-nav me-3 mb-2 mb-lg-0 gap-2 col-auto">
          <li class="nav-item dropdown btn navbar-btn">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              style="color: white"
            >
              <i class="fa-solid fa-bars me-1"></i>Danh mục
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li>
                <a class="dropdown-item" href="#">Another action</a>
              </li>
              <li>
                <a class="dropdown-item" href="#">Something else here</a>
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown btn navbar-btn">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              style="color: white"
            >
              <i class="fa-solid fa-location-dot me-1"></i>Hà nội
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="#">TP. Hồ Chí Minh</a>
              </li>
              <li>
                <a class="dropdown-item" href="#">Đà Nẵng</a>
              </li>
              <li>
                <a class="dropdown-item" href="#">Nha Trang</a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Ô tìm kiếm -->
          <div class="col input-group same-height">
            
            <form action="{{ route('products.searchCustomer') }}" method="get" class="input-group">
              <span class="input-group-text" style="background-color: white"
              ><i class="fa-solid fa-magnifying-glass"></i
              ></span>
              <input
              type="text"
              name="input"
              class="form-control"
              placeholder="Bạn muốn mua gì hôm nay?"
              aria-label="Ô tìm kiếm"
              />
            </form>
          </div>


          {{-- Giỏ hàng và thông tin người dùng --}}
        <ul class="navbar-nav me-3 mb-2 mb-lg-0 gap-2 col-auto">
          @auth
          <li class="nav-item btn" style="font-weight: 500">
            <a
              class="nav-link active"
              aria-current="page"
              href="{{ route('cart.index') }}"
              style="color: white"
              ><i class="fa-solid fa-cart-shopping me-1"></i>Giỏ hàng</a
            >
          </li>
          <li class="nav-item btn navbar-btn dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              style="color: white"
            >
              <i class="fa-solid fa-user me-1"></i>{{ auth()->user()->FullName }}
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="user/overall/{{ auth()->user()->UserID }}" class="dropdown-item">
                  Thông tin người dùng
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a href="{{ route('logout') }}" class="dropdown-item">Đăng xuất</a>
              </li>
            </ul>
          </li>
          
          @endauth

          {{-- Nếu chưa đăng nhập --}}
          @guest
            <li class="nav-item btn navbar-btn">
            <a
              class="nav-link active"
              aria-current="page"
              href="register"
              style="color: white; font-weight: 500"
              ><i class="fa-solid fa-user me-1"></i>Đăng kí</a
            >
            <li class="nav-item btn navbar-btn">
              <a
                class="nav-link active"
                aria-current="page"
                href="{{ route('login') }}"
                style="color: white; font-weight: 500"
                ><i class="fa-solid fa-user me-1"></i>Đăng nhập</a
              >
          @endguest
        </ul>
      </div>
    </div>
  </nav>
</div>
