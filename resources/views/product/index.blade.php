@extends('layouts.homePage')

@section('content')
    <!-- Sản phẩm -->
    <div class="products-section mt-3">
        <!-- Tiêu đề -->
        <div class="d-flex flex-column flex-md-row">
          <h4 class="me-auto">CÁC SẢN PHẨM ĐIỆN THOẠI</h4>
          <div class="d-flex flex-nowrap overflow-auto gap-2">
            <button class="btn btn-dark">Xem thêm</button>
            
          </div>
        </div>

        <!-- Các sản phẩm -->
        <div
          class="d-flex flex-wrap mt-3 justify-content-center"
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
                  <span class="text-danger fw-bold fs-6">{{ number_format($product->Price, 0, ',','.') }}đ</span>
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

    {{-- pagination --}}
    @if ($products->hasPages())
      <div class="d-flex justify-content-center mt-3">
          <nav aria-label="Page navigation">
              <ul class="pagination">
                  {{-- Previous Page Link --}}
                  <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                      <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                      </a>
                  </li>

                  {{-- Pagination Elements --}}
                  @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                      <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                          <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                      </li>
                  @endforeach

                  {{-- Next Page Link --}}
                  <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                      <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              </ul>
          </nav>
      </div>
    @endif
@endsection