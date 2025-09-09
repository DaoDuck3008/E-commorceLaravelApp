@extends('layouts.app')

@section('content')
<main class="container mt-3">
    <!-- Điều hướng trang  -->
    <div class="d-flex" style="font-size: small">
      <i class="fa-solid fa-house mt-1 me-2"></i>
      <p>
        <b> Trang chủ / Điện thoại / Apple / Iphone /</b> iphone 16 Pro Max
        256GB | Chính hãng VN/A
      </p>
    </div>

    <!-- Sản phẩm chi tiết -->
    <div class="product-container row">
      <!-- PHÍA BÊN TRÁI -->
      <div class="col-12 col-md-6">
        <!-- Tên sản phẩm -->
        <h4>{{ $product->ProductName }}</h4>
        <div class="d-flex">
          <i class="fa-solid fa-star mt-1 me-2" style="color: #ffd43b"></i>
          <p><b>4.9</b> (329 đánh giá)</p>
        </div>
        <!-- Yêu thích / hỏi đáp / thông số / so sánh -->
        <div class="d-flex" style="color: #4a8cf7">
          <div class="d-flex">
            <i class="fa-regular fa-heart mt-1 me-2"></i>
            <p>Yêu thích</p>
            <p class="mx-3">|</p>
          </div>
          <div class="d-flex">
            <i class="fa-regular fa-comment mt-1 me-2"></i>
            <p>Hỏi đáp</p>
            <p class="mx-3">|</p>
          </div>
          <div class="d-flex">
            <i class="fa-solid fa-microchip mt-1 me-2"></i>
            <p>Thông số</p>
            <p class="mx-3">|</p>
          </div>
          <div class="d-flex">
            <i class="fa-solid fa-circle-plus mt-1 me-2"></i>
            <p>So sánh</p>
            <p class="mx-3">|</p>
          </div>
        </div>
        <!-- Ảnh sản phẩm -->
        <div
          id="productCarousel"
          class="carousel slide"
          data-bs-ride="carousel"
        >
          <!-- Main Carousel -->
          <div class="carousel-inner text-center ads-container-product">
            @foreach($product->productImgs as $index => $img)
            <div class="carousel-item-product {{ $index == 0 ? "active" : "" }} ">
              <img
                src="{{ $img->ImgURL }}"
                alt="ảnh sản phẩm {{ $index+1 }}"
              />
            </div>
            @endforeach
          </div>

          <!-- Controls -->
          <button
            class="carousel-control-prev carousel-control"
            type="button"
            data-bs-target="#productCarousel"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button
            class="carousel-control-next carousel-control"
            type="button"
            data-bs-target="#productCarousel"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
        <!-- Thumbnails -->
        <div
          class="d-flex justify-content-left mt-3 gap-2 flex-nowrap overflow-x-auto overflow-y-hidden"
        >
          @foreach ($product->productImgs as $index => $img)
            <img
            src="{{ $img->ImgURL }}"
            width="80"
            height="80"
            class="thumb {{ $index == 0 ? "active" : "" }}"
            data-bs-target="#productCarousel"
            data-bs-slide-to="{{ $index }}"
          />
          @endforeach
        </div>

        <!-- Thông số kĩ thuật -->
        <div class="product-specifications mt-4">
          <h5>Thông số kỹ thuật</h5>
          <table class="mt-2 table table-border shadow rounded custom-table">
            @foreach ( $product->productspecifications   as $spec )
              <tr>
                <td class="bg-body-secondary" width="40%">
                  {{ $spec->SpecType }}
                </td>
                <td style="white-space: pre-line;">{{ $spec->SpecValue }}</td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>

      <!-- PHÍA BÊN PHẢI -->
      <div class="col-12 col-md-6">
        <!-- Giá -->
        <button
          class="btn border border-primary"
          style="background-color: #f2f7ff; border-radius: 15px"
        >
          <p
            class="rounded mt-1"
            style="
              background-color: #fbe6e8;
              color: #e03c4e;
              font-weight: 500;
            "
          >
            Giá dành riêng cho MEMBER
          </p>
          <div class="d-flex">
            <h3 id="member-price"> {{ number_format($product->productVersions[0]->Price, 0, ',', '.') }}đ</h3>
            <p id="old-price" class="text-muted text-decoration-line-through ms-3">
              {{ number_format($product->productVersions[0]->Price + 1000000, 0, ',', '.') }}đ
            </p>
          </div>
        </button>

        <!-- Loại -->
        <div class="version mt-4">
          <!-- Phiên bản -->
          <h5><strong>Phiên bản</strong></h5>
          <div role="group" aria-label="Chọn phiên bản">
            @foreach ($product->productVersions as $index => $version)
              <input
              type="radio"
              class="btn-check"
              name="productVersion"
              id="version-{{ $index }}"
              data-price="{{ $version->Price }}"
              autocomplete="off"
              {{ $index == 0 ? "checked" : "" }}
              />
              <label class="btn px-4 py-3 mx-1" for="version-{{ $index }}">{{ $version->VersionName }}</label>
            @endforeach
          </div>

          <!-- Màu sắc -->
          <h5 class="mt-2"><strong>Màu sắc</strong></h5>
          <div role="group" aria-label="Chọn Màu sắc">
            @foreach ($product->productColors as $index => $color )
              <input
              type="radio"
              class="btn-check"
              name="color"
              id="color{{ $index }}"
              autocomplete="off"
              {{ $index == 0 ? "checked" : "" }}
              />
              <label class="btn mx-1 my-2" for="color{{ $index }}">
                <div class="d-flex">
                  <img
                    width="50"
                    height="50"
                    src="{{ $color->ImgURL }}"
                  />
                  <div>
                    <strong>{{ $color->Color }}</strong>
                  </div>
                </div>
              </label>
            @endforeach
          </div>
        </div>

        <!-- Chi nhánh các cửa hàng -->
        <div class="container mt-2">
          <div class="pt-3 ps-2 bg-light border rounded row">
            <!-- Xem chi nhánh của hàng -->
            <div class="d-flex flex-wrap mb-2">
              <div class="me-1">
                <strong>Xem chi nhánh có hàng</strong><br />
                Có <span class="text-primary">28</span> cửa hàng có sẵn sản
                phẩm
              </div>

              <!-- Dropdown -->
              <div class="mx-1">
                <select class="form-select" style="width: auto">
                  <option>Hà Nội</option>
                  <option>Hồ Chí Minh</option>
                </select>
              </div>
              <div class="mx-1">
                <select class="form-select" style="width: auto">
                  <option>Quận/Huyện</option>
                  <option>Hai Bà Trưng</option>
                  <option>Đống Đa</option>
                </select>
              </div>
            </div>

            <!-- Danh sách cửa hàng -->
            <div
              class="store-list d-flex flex-nowrap overflow-x-auto overflow-y-hidden gap-2 mb-3"
            >
              <div class="store-card">
                <div class="mb-2 fw-semibold">
                  51 Đại Cồ Việt, Phường Lê Đại Hành, Quận Hai Bà Trưng
                </div>
                <div class="d-flex gap-2">
                  <span class="phone-badge">
                    <i
                      class="fa-solid fa-phone me-1"
                      style="color: #d70018"
                    ></i>
                    02471000051
                  </span>
                  <span class="map-badge">
                    <i
                      class="fa-solid fa-location-dot me-1"
                      style="color: #d70018"
                    ></i>
                    Bản đồ
                  </span>
                </div>
              </div>

              <div class="store-card">
                <div class="mb-2 fw-semibold">
                  282 Minh Khai, Q. Hai Bà Trưng, Hà Nội
                </div>
                <div class="d-flex gap-2">
                  <span class="phone-badge">
                    <i
                      class="fa-solid fa-phone me-1"
                      style="color: #d70018"
                    ></i>
                    02471010282
                  </span>
                  <span class="map-badge">
                    <i
                      class="fa-solid fa-location-dot me-1"
                      style="color: #d70018"
                    ></i>
                    Bản đồ
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="row mt-3 d-flex justify-content-center">
          <div
            class="col-2 btn d-flex align-items-center"
            style="
              color: #3b82f6;
              font-weight: 600;
              border: 2px solid #3b82f6;
              border-radius: 10px;
            "
          >
            Trả góp 0%
          </div>
          <div
            class="col-6 d-flex flex-column align-items-center btn mx-2"
            style="
              color: white;
              background: linear-gradient(to bottom, #ff4b4b, #d40000);
            "
          >
            <h5 class="mt-1">MUA NGAY</h5>
            <p>Giao nhanh 2 giờ hoặc nhận tại cửa hàng</p>
          </div>
          <div class="col-3 btn ">
            <form  method='post' action="{{ auth() ? route('cart.addItem',['productID'=> $product->ProductID,'userID' => auth()->user()->UserID]) : route('login') }}">
              @csrf
              <button
                class=" d-flex align-items-center justify-content-center"
                style="
                  color: #e03c4e;
                  font-weight: 600;
                  border: 2px solid #e03c4e;
                  border-radius: 10px;
                "
                type="submit"
              >
                <i class="fa-solid fa-cart-plus me-2"></i>
                Thêm vào giỏ hàng
              </button>
            </form>
          </div>
        </div>

        <!-- Video youtube -->
        <div class="container my-4">
          <div class="ratio ratio-16x9 border rounded shadow">
            <iframe
              src="{{ $product->VideoLink }}"
              title="YouTube video player"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              referrerpolicy="strict-origin-when-cross-origin"
              allowfullscreen
            ></iframe>
          </div>
        </div>
      </div>
    </div>

    <!-- Đánh giá sản phẩm -->
    <div class="comment-container mt-4">
      <h4 class="m-3">Đánh giá iPhone 16 Pro Max 256GB | Chính hãng VN/A</h4>
      <div class="rating-container row m-3">
        <div
          class="overall-rating col-3 d-flex flex-column align-items-center my-3"
        >
          <div class="d-flex">
            <h1>5.0</h1>
            <h2 style="color: #a1a1aa">/5</h2>
          </div>
          <div class="d-flex gap-1">
            <i class="fa-solid fa-star" style="color: #ffd43b"></i
            ><i class="fa-solid fa-star" style="color: #ffd43b"></i
            ><i class="fa-solid fa-star" style="color: #ffd43b"></i
            ><i class="fa-solid fa-star" style="color: #ffd43b"></i>
            <i class="fa-solid fa-star" style="color: #ffd43b"></i>
          </div>
          <p>45 lượt đánh giá</p>
          <button
            class="btn rounded"
            style="background-color: #d7000e; color: white; font-weight: 600"
          >
            Viết đánh giá
          </button>
        </div>
        <!-- Lượt đánh giá -->
        <div
          class="detailed-rating col-9 d-flex flex-column align-items-center my-3"
        >
          <div class="container mt-3" style="max-width: 800px">
            <!-- 5 sao -->
            <div class="d-flex align-items-center mb-2">
              <div class="me-2">
                5 <i class="fa-solid fa-star" style="color: gold"></i>
              </div>
              <div
                class="progress flex-grow-1"
                style="height: 8px; border-radius: 50px"
              >
                <div
                  class="progress-bar"
                  style="
                    width: 95%;
                    background-color: red;
                    border-radius: 50px;
                  "
                ></div>
              </div>
              <div class="ms-2 text-muted" style="white-space: nowrap">
                44 đánh giá
              </div>
            </div>

            <!-- 4 sao -->
            <div class="d-flex align-items-center mb-2">
              <div class="me-2">
                4 <i class="fa-solid fa-star" style="color: gold"></i>
              </div>
              <div
                class="progress flex-grow-1"
                style="height: 8px; border-radius: 50px"
              >
                <div
                  class="progress-bar"
                  style="
                    width: 5%;
                    background-color: red;
                    border-radius: 50px;
                  "
                ></div>
              </div>
              <div class="ms-2 text-muted" style="white-space: nowrap">
                1 đánh giá
              </div>
            </div>

            <!-- 3 sao -->
            <div class="d-flex align-items-center mb-2">
              <div class="me-2">
                3 <i class="fa-solid fa-star" style="color: gold"></i>
              </div>
              <div
                class="progress flex-grow-1"
                style="height: 8px; border-radius: 50px"
              >
                <div
                  class="progress-bar"
                  style="
                    width: 0%;
                    background-color: red;
                    border-radius: 50px;
                  "
                ></div>
              </div>
              <div class="ms-2 text-muted" style="white-space: nowrap">
                0 đánh giá
              </div>
            </div>

            <!-- 2 sao -->
            <div class="d-flex align-items-center mb-2">
              <div class="me-2">
                2 <i class="fa-solid fa-star" style="color: gold"></i>
              </div>
              <div
                class="progress flex-grow-1"
                style="height: 8px; border-radius: 50px"
              >
                <div
                  class="progress-bar"
                  style="
                    width: 0%;
                    background-color: red;
                    border-radius: 50px;
                  "
                ></div>
              </div>
              <div class="ms-2 text-muted" style="white-space: nowrap">
                0 đánh giá
              </div>
            </div>

            <!-- 1 sao -->
            <div class="d-flex align-items-center">
              <div class="me-2">
                1 <i class="fa-solid fa-star" style="color: gold"></i>
              </div>
              <div
                class="progress flex-grow-1"
                style="height: 8px; border-radius: 50px"
              >
                <div
                  class="progress-bar"
                  style="
                    width: 0%;
                    background-color: red;
                    border-radius: 50px;
                  "
                ></div>
              </div>
              <div class="ms-2 text-muted" style="white-space: nowrap">
                0 đánh giá
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Các bình luận -->
      <div class="rating-container mt-5 m-3">
        <!-- Comment 1 -->
        <div class="row mt-2">
          <div class="col-3 d-flex">
            <div class="avatar ms-3 me-2">
              <img
                src="https://cdn.kwork.com/files/portfolio/t3/24/a5bf8465becd2274bd38894122c7020e96115673-1711803733.jpg"
              />
            </div>
            <strong>Nguyễn Tấn Tài</strong>
          </div>
          <div class="col-9">
            <div class="d-flex gap-1 my-1 mb-4">
              <i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i>
              <i class="fa-solid fa-star" style="color: #ffd43b"></i>
            </div>
            <div class="my-2">
              airpods 4 vừa mua ở TGDD hơn 1 tháng shop thu lại được nhiêu nhỉ
            </div>
            <div class="d-flex my-1">
              <i
                class="fa-regular fa-clock me-1 mt-1"
                style="color: #a1a1bd"
              ></i
              >Đánh giá đã đăng vào 6 ngày trước
            </div>
          </div>
        </div>
        <hr />

        <!-- Comment 2 -->
        <div class="row mt-2">
          <div class="col-3 d-flex">
            <div class="avatar ms-3 me-2">
              <img
                src="https://cdn.kwork.com/files/portfolio/t3/24/a5bf8465becd2274bd38894122c7020e96115673-1711803733.jpg"
              />
            </div>
            <strong>Bùi Nguyễn Minh hiếu</strong>
          </div>
          <div class="col-9">
            <div class="d-flex gap-1 my-1 mb-4">
              <i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i>
              <i class="fa-solid fa-star" style="color: #ffd43b"></i>
            </div>
            <div class="my-2">đã mua hàng, chất lượng tốt</div>
            <div class="d-flex my-1">
              <i
                class="fa-regular fa-clock me-1 mt-1"
                style="color: #a1a1bd"
              ></i
              >Đánh giá đã đăng vào 6 ngày trước
            </div>
          </div>
        </div>
        <hr />

        <!-- Comment 3 -->
        <div class="row mt-2">
          <div class="col-3 d-flex">
            <div class="avatar ms-3 me-2">
              <img
                src="https://cdn.kwork.com/files/portfolio/t3/24/a5bf8465becd2274bd38894122c7020e96115673-1711803733.jpg"
              />
            </div>
            <strong>Đào Anh Đức</strong>
          </div>
          <div class="col-9">
            <div class="d-flex gap-1 my-1 mb-4">
              <i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i>
              <i class="fa-solid fa-star" style="color: #ffd43b"></i>
            </div>
            <div class="my-2">Có cái Iphone nhìn sang hẳn</div>
            <div class="d-flex my-1">
              <i
                class="fa-regular fa-clock me-1 mt-1"
                style="color: #a1a1bd"
              ></i
              >Đánh giá đã đăng vào 6 ngày trước
            </div>
          </div>
        </div>
        <hr />

        <!-- Comment 4 -->
        <div class="row mt-2">
          <div class="col-3 d-flex">
            <div class="avatar ms-3 me-2">
              <img
                src="https://cdn.kwork.com/files/portfolio/t3/24/a5bf8465becd2274bd38894122c7020e96115673-1711803733.jpg"
              />
            </div>
            <strong>Nguyễn Tuấn Thành</strong>
          </div>
          <div class="col-9">
            <div class="d-flex gap-1 my-1 mb-4">
              <i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i
              ><i class="fa-solid fa-star" style="color: #ffd43b"></i>
              <i class="fa-solid fa-star" style="color: #ffd43b"></i>
            </div>
            <div class="my-2">
              iPhone 16 Pro Max sở hữu chipset A18 Pro mạnh mẽ giúp xử lý
              nhanh mọi tác vụ, camera 48 MP zoom quang 5x cho ảnh nét, màn
              hình 6.9 inch sống động. Pin dung lượng cao của máy hỗ trợ phát
              video tới 33 tiếng, đáp ứng nhu cầu giải trí liên tục suốt ngày
              dài. Cùng với đó là thiết kế khung Titanium bền nhẹ, mang lại
              cảm giác sang trọng và chắc chắn khi cầm.
            </div>
            <div class="d-flex my-1">
              <i
                class="fa-regular fa-clock me-1 mt-1"
                style="color: #a1a1bd"
              ></i
              >Đánh giá đã đăng vào 6 ngày trước
            </div>
          </div>
        </div>
        <hr />
      </div>
    </div>
</main>

<script>
  const carouselElement = document.querySelector("#productCarousel");
  const thumbnails = document.querySelectorAll(".thumb");

  carouselElement.addEventListener("slid.bs.carousel", (e) => {
    // Xóa active cũ
    thumbnails.forEach((thumb) => thumb.classList.remove("active"));
    // Thêm active mới
    thumbnails[e.to].classList.add("active");
  });

  // Hàm format giá tiền
  function formatPrice(price) {
    return price.toLocaleString('vi-VN') + 'đ';
  }

  // Event listener cho các radio button phiên bản
  document.querySelectorAll('input[name="productVersion"]').forEach(radio => {
    radio.addEventListener('change', function() {
      let price = parseInt(this.dataset.price);
      
      // Cập nhật giá member
      document.getElementById('member-price').textContent = formatPrice(price);
      // Cập nhật giá cũ (giá gạch ngang)
      document.getElementById('old-price').textContent = formatPrice(price + 1000000);
    });
  });
</script>
@endsection