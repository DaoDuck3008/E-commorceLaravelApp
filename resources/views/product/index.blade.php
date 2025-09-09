@extends('layouts.homePage')

@section('content')
    <!-- Sản phẩm -->
    <div class="products-section mt-3">
        <!-- Tiêu đề -->
        <div class="d-flex flex-column flex-md-row">
          <h4 class="me-auto">CÁC SẢN PHẨM NỔI BẬT</h4>
          <div class="d-flex flex-nowrap overflow-auto gap-2">
            <button class="btn" style="background-color: #f3f4f6">Apple</button>
            <button class="btn" style="background-color: #f3f4f6">
              Samsung
            </button>
            <button class="btn" style="background-color: #f3f4f6">Asus</button>

            <button class="btn" style="background-color: #f3f4f6">
              Xiaomi
            </button>
            <button class="btn" style="background-color: #f3f4f6">
              Lenovo
            </button>
            <button class="btn" style="background-color: #f3f4f6">Oppo</button>
            <button class="btn" style="background-color: #f3f4f6">Nokia</button>
            <button class="btn" style="background-color: #f3f4f6">Vivo</button>
            <button class="btn" style="background-color: #f3f4f6">
              Microsoft
            </button>
            <button class="btn" style="background-color: #f3f4f6">Alien</button>
          </div>
        </div>

        <!-- Các sản phẩm -->
        <div
          class="d-flex flex-wrap mt-3 justify-content-left"
        >
          @foreach ( $products as $product )
          <a
              class="card p-3 rounded shadow position-relative mx-2 mt-3 btn"
              href="/products/{{ $product->ProductID }}"
              style="
              background: linear-gradient(180deg, #fff, #ffeceb);
              width: 220px;
              min-width: 220px;
              "
          >
              <span class="badge bg-danger position-absolute top-0 start-0 m-2"
              >Giảm 3%</span
              >

              <img
              src="{{ $product->ImageURL }}"
              class="card-img-top mt-4"
              alt="CPU AMD Ryzen 5 5600"
              />

              <div class="card-body p-0 mt-2">
              <h6 class="card-title mb-2">
                  {{ $product->ProductName }}
              </h6>
              <div class="d-flex align-items-baseline gap-2">
                  <span class="text-danger fw-bold fs-6">{{ $product->Price }}đ</span>
                  <small class="text-muted text-decoration-line-through"
                  >34.990.000đ</small
                  >
              </div>
              <div class="bg-light text-secondary small px-2 py-1 rounded mt-1">
                  Giá S-Student 3.705.000đ
              </div>
              <div class="d-flex flex-row-reverse mt-2">
                  <btn class="btn btn-primary">♡ Yêu thích</btn>
              </div>
              </div>
          </a>
          @endforeach
      </div>
    </div>
@endsection