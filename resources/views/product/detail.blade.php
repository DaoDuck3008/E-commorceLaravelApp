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


        {{--  --}}
        {{-- Form thêm vào giỏ hàng --}}
        <form action="{{ route('cart.addItem') }}" method="post">
        @csrf
          {{-- truyền productID --}}
          <input type="hidden" name="productID" value="{{ $product->ProductID }}"/>  

          <!-- Loại -->
          <div class="version mt-4">
            <!-- Phiên bản -->
            <h5><strong>Phiên bản</strong></h5>
            <div role="group" aria-label="Chọn phiên bản">
              @foreach ($product->productVersions as $index => $version)
                <input
                type="radio"
                class="btn-check"
                name="versionID"
                id="version-{{ $index }}"
                value="{{ $version->VersionID }}"
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
                name="colorID"
                id="color{{ $index }}"
                value="{{ $color->ColorID }}"
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
            </div>
          </div>
        </form>
        

        

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


      <!--Viết đánh giá-->
              <style>
                body {
                  font-family: Arial, sans-serif;
                  background: #f5f5f5;
                }

        
            #openModal {
              padding: 10px 20px;
              border-radius: 8px;
              background: #d7000e;
              color: #fff;
              font-weight: 600;
              border: none;
              cursor: pointer;
              transition: background 0.3s;
            }
          #openModal:hover {
            background: #b8000c;
          }

          .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
          }
          .modal-content {
            background: #fff;
            border-radius: 12px;
            width: 600px;
            max-width: 95%;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            animation: fadeIn 0.25s ease-in-out;
          }

          .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
            padding-bottom: 10px;
          }

          .modal-header h2 {
          margin: 0;
          font-size: 20px;
          font-weight: 700;   
          color: #333;
          text-align: center; 
          flex: 1;            
          }
          .close {
            cursor: pointer;
            font-size: 22px;
            font-weight: bold;
            color: #666;
          }
          .close:hover {
            color: #000;
          }

          .stars {
            display: flex;
            justify-content: space-between; /* chia đều các sao */
            font-size: 28px;
            color: #ccc;
            cursor: pointer;  
          }

          .rating-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 12px 0;
          }

          .rating-row span {
            font-weight: 500;
            color: #444;
          }

          textarea {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            min-height: 100px;
            resize: vertical;
            font-size: 14px;
            margin-top: 8px;
            outline: none;
          }

          textarea:focus {
            border-color: #d7000e;
            box-shadow: 0 0 4px rgba(215, 0, 14, 0.5);
          }

          .btn-submit {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #d7000e;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
          }
          .btn-submit:hover {
            background: #b8000c;
          }
        </style>
      <body>
        <button id="openModal">Viết đánh giá</button>

<div id="reviewModal" class="modal" style="display:none;">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Đánh giá & nhận xét</h2>
      <span class="close" id="closeModal">&times;</span>
    </div>

    <form method="POST" action="{{ route('reviews.store') }}">
      @csrf
      <input type="hidden" name="ProductID" value="{{ $product->ProductID }}">
      <input type="hidden" name="Rating" id="ratingInput">

      <label><b>Đánh giá chung:</b></label>
      <div class="stars" id="stars" style="font-size:30px; cursor:pointer;">
        <span class="star" data-value="1">★</span>
        <span class="star" data-value="2">★</span>
        <span class="star" data-value="3">★</span>
        <span class="star" data-value="4">★</span>
        <span class="star" data-value="5">★</span>
      </div>

      <div style="display:flex; justify-content:space-between; font-size:13px; color:#777; margin-top:4px;">
        <span>Rất tệ</span>
        <span>Tuyệt vời</span>
      </div>

      <div style="margin-top:20px;">
        <textarea name="comment" placeholder="Xin mời chia sẻ cảm nhận về sản phẩm (tối thiểu 15 ký tự)..." required></textarea>
      </div>

      <button type="submit" class="btn-submit">GỬI ĐÁNH GIÁ</button>
    </form>
  </div>
</div>

<script>
  const modal = document.getElementById("reviewModal");
  const openBtn = document.getElementById("openModal");
  const closeBtn = document.getElementById("closeModal");

  // mở modal
  openBtn.onclick = () => modal.style.display = "flex";
  closeBtn.onclick = () => modal.style.display = "none";
  window.onclick = (e) => { if (e.target == modal) modal.style.display = "none"; }

  // xử lý rating
  const stars = document.querySelectorAll("#stars .star");
  const ratingInput = document.getElementById("ratingInput"); // đúng id của hidden input

  stars.forEach((star, index) => {
    star.addEventListener("click", () => {
      stars.forEach((s, i) => {
        s.style.color = i <= index ? "#fbbf24" : "#ccc";
      });
      ratingInput.value = index + 1; // lưu giá trị rating vào input hidden
    });
  });
</script>

      </body>

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

      <!--Viết bình luận-->
        <style>
          star-rating {
        direction: rtl; 
        display: inline-flex;
      }
      .star-rating input {
        display: none;
      }
      .star-rating label {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        padding: 0 3px;
      }
      .star-rating input:checked ~ label,
      .star-rating label:hover,
      .star-rating label:hover ~ label {
        color: #ffc107; 
      }
          .comment-box {
        border-radius: 15px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 20px;
      }
      .rounded-input {
        border-radius: 10px !important;
      }
      .btn-submit {
        border-radius: 50px !important;
        padding: 10px 25px;
        font-weight: 600;
        background: linear-gradient(45deg, #ff4b2b, #ff416c);
        border: none;
        color: #fff;
        transition: all 0.3s ease-in-out;
      }
      .btn-submit:hover {
        opacity: 0.9;
        transform: scale(1.05);
      }
      .rating {
        direction: rtl;
        unicode-bidi: bidi-override;
        display: inline-flex;
      }
      .rating input { display: none; }
      .rating label {
        font-size: 1.8rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.3s ease, transform 0.2s;
      }
      .rating input:checked ~ label,
      .rating label:hover,
      .rating label:hover ~ label {
        color: #ffc107;
        transform: scale(1.2);
      }
      .comment-item {
        border-radius: 15px;
        padding: 15px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        margin-bottom: 15px;
      }

        </style>
        <div class="container my-4">
            
          {{-- Form gửi bình luận (nếu đã login) --}}
          @if(auth()->check())
              <div class="comment-box">
                  <h5 class="mb-3 fw-bold">Viết bình luận</h5>
                  <form method="POST" action="{{ route('reviews.store') }}">
                      @csrf
                      <div class="mb-3">
          <label class="form-label fw-bold">Đánh giá:</label>
          <div class="star-rating">
              <input type="hidden" name = ProductID value = "{{ $product-> ProductID }}" required>
              <input type="radio" id="star5" name="rating" value="5" required>
              <label for="star5">★</label>

              <input type="radio" id="star4" name="rating" value="4">
              <label for="star4">★</label>

              <input type="radio" id="star3" name="rating" value="3">
              <label for="star3">★</label>

              <input type="radio" id="star2" name="rating" value="2">
              <label for="star2">★</label>

              <input type="radio" id="star1" name="rating" value="1">
              <label for="star1">★</label>
          </div>
                      <div class="mb-3">
                          <textarea name="COMMENT" rows="3" class="form-control rounded-input" placeholder="Viết bình luận..." required></textarea>
                      </div>
                      <button type="submit" class="btn btn-submit">
                          <i class="bi bi-send-fill me-1"></i> Gửi bình luận
                      </button>
                  </form>
              </div>
          @else

            <div class="login-notice-wrapper">
          <p class="login-notice">
              <a href="{{ route('login') }}">Bạn cần đăng nhập để bình luận.</a> 
          </p>
      </div>

        <style>
        .login-notice-wrapper {
            display: flex;            /* bật flex */
            justify-content: center;  /* căn giữa ngang */
            margin: 20px 0;           /* khoảng cách trên/dưới */
        }

        .login-notice {
            background-color: #ffe5e5;
            color: #d32f2f;
            border: 1px solid #d32f2f;
            border-radius: 12px;
            padding: 12px 16px;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .login-notice a {
            color: #d32f2f;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed #d32f2f;
            transition: all 0.3s ease;
        }

        .login-notice:hover {
            background-color: #ffd6d6;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
        }

        .login-notice a:hover {
            color: #b71c1c;
            border-bottom: 1px solid #b71c1c;
        }
        </style>

@endif

</div>

<hr>


<!-- Danh sách bình luận -->
<div class="container my-4">
    <!-- Khung chung -->
    <div class="border rounded p-4 bg-white shadow-sm">

        <!-- Lọc đánh giá -->
        <div class="mb-4">
            <h5 class="fw-bold mb-3">Lọc đánh giá theo</h5>
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-sm btn-outline-secondary rounded-pill active">Tất cả</button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill">Có hình ảnh</button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill">Đã mua hàng</button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill">5 sao</button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill">4 sao</button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill">3 sao</button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill">2 sao</button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill">1 sao</button>
            </div>
        </div>

        <!-- Danh sách bình luận -->
        @forelse($product->reviews as $review)
            <div class="d-flex border-bottom pb-3 mb-3">
                <!-- Avatar -->
                <div class="me-3">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white fw-bold" style="width:50px; height:50px;">
                        {{ strtoupper(substr($review->user->FullName ?? 'Ẩn', 0, 1)) }}
                    </div>
                </div>

                <!-- Nội dung -->
                <div class="flex-grow-1">
                    <!-- Username -->
                    <strong class="d-block">{{ $review->user->FullName ?? 'Người dùng đã xóa' }}</strong>

                    <!-- Sao + tiêu đề -->
                    <div class="d-flex align-items-center mb-1">
                        <div class="me-2">
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star-fill" style="color: {{ $i <= ($review->Rating ?? 0) ? '#ffc107' : '#e4e5e9' }}"></i>
                            @endfor
                        </div>
                        <span class="fw-semibold text-success">Tuyệt vời</span>
                    </div>

                    <!-- Nội dung bình luận -->
                    <p class="mb-2">{{ $review->COMMENT }}</p>

                    <!-- Thời gian + nút -->
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted d-flex align-items-center">
                            <i class="bi bi-clock me-1"></i>
                            {{ $review->CreatedAt ? $review->CreatedAt->diffForHumans() : '' }}
                        </small>

                            @if(auth()->check() && (auth()->user()->UserID == $review->user->UserID || auth()->user()->Role === 'Admin'))
                                <div class="d-flex gap-2">
                                    @if(auth()->user()->UserID == $review->user->UserID)
                                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#editReview{{ $review->ReviewID }}">
                                            Cập nhật
                                        </button>
                                    @endif

                                    <!-- Nút xóa -->
                                    <form method="POST" action="{{ route('reviews.destroy', $review->ReviewID) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                    </form>
                                </div>
                            @endif
                        </div>


                    <!-- Form cập nhật -->
                    <div class="collapse mt-3" id="editReview{{ $review->ReviewID }}">
                        <form method="post" action="{{ route('reviews.update', $review->ReviewID) }}">
                            @csrf
                            @method('PUT')
          
                          <style>
                                .star-rating {
                                    direction: rtl; /* để chọn từ phải qua trái */
                                    display: inline-flex;
                                    font-size: 1.5rem;
                                }
                                .star-rating input {
                                    display: none; /* ẩn radio */
                                }
                                .star-rating label {
                                    color: #e4e5e9;
                                    cursor: pointer;
                                    transition: color 0.2s;
                                }
                                .star-rating input:checked ~ label,
                                .star-rating label:hover,
                                .star-rating label:hover ~ label {
                                    color: #ffc107; /* màu vàng cho sao được chọn */
                                }
                            </style>
                            <!-- Chỉnh sửa sao đẹp -->
                                <div class="mb-2">
                                    <label class="form-label">Đánh giá sao:</label>
                                    <div class="star-rating">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="edit-star{{ $i }}-{{ $review->ReviewID }}" 
                                                  name="rating" value="{{ $i }}" 
                                                  @if($review->Rating == $i) checked @endif>
                                            <label for="edit-star{{ $i }}-{{ $review->ReviewID }}">★</label>
                                        @endfor
                                    </div>
                                </div>

                            <textarea name="comment" class="form-control mb-2">{{ $review->COMMENT }}</textarea>
                            <button type="submit" class="btn btn-sm btn-success">Lưu thay đổi</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="collapse" data-bs-target="#editReview{{ $review->ReviewID }}">
                                Hủy
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
        @endforelse
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">






      
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