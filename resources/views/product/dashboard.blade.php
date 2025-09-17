@extends('admin.app')

@section('title')
    <title>Quản lý sản phẩm</title>
@endsection

@section('style')
  <style>
    .icon{
      border-radius: 50%;
    }
  </style>
@endsection

@section('content')
    <!-- Cards -->
    <div class="row g-3">
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng mặt hàng</h6>
            <div class="d-flex justify-content-between">
              <h3>{{ $products->count() }}</h3>
              <h3 class="icon bg-info ps-1 py-1"><i class="fa-solid fa-folder text-white me-2"></i></h3>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng số lượng trong kho</h6>
            <div class="d-flex justify-content-between">
              <h3>{{ $products->first() ? number_format($products->first()->getTotalStockQuantity(), 0,',','.') : 0 }}</h3>
              <h3 class="icon bg-secondary ps-1 py-1"><i class="fa-solid fa-copy text-white me-2"></i></h3>
        </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Mặt hàng Điện thoại</h6>
            <div class="d-flex justify-content-between">
              <h3>{{$products->first() ? $products->first()->getTotalLaptop() : 0}}</h3>
              <h3 class="icon bg-warning ps-2 pe-1 py-1"><i class="fa-solid fa-mobile-screen-button text-white me-2"></i></h3>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Mặt hàng Laptop & Máy tính</h6>
            <div class="d-flex justify-content-between">
              <h3>{{ $products->first() ? $products->first()->getTotalLaptop() : 0 }}</h3>
              <h3 class="icon bg-success py-2 ps-1"><i class="fa-solid fa-laptop text-white me-2"></i></h3>
            </div>
        </div>
        </div>
    </div>

    <!-- Topbar -->
    @include('components.search.productDasboard')

    <div class="row g-3 ">
        <div class="col-md-12">
        <div class="card-custom">
            <div class="d-flex my-2 ">
              <h4 class="me-auto text-danger"><strong><i class="fa-solid fa-window-restore me-2"></i>Biểu đồ hàng hóa</strong></h4>
              <a href="admin/products/create" class="btn btn-success">Thêm mới sản phẩm</a>
            </div>
            <div class="table-responsive rounded" style="max-height: 1000px; overflow-y: auto; overflow-x: auto">
                <table class="table table-hover align-middle " >
                  <thead class="table-danger sticky-top" >
                    <tr >
                      <th scope="col">#</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Product Image</th>
                      <th scope="col">Category</th>
                      <th scope="col">Brand</th>
                      <th scope="col">Price</th>
                      <th scope="col">Stock Quantity</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody style="max-height: 400px; overflow-y: auto; overflow-x:auto" >
                    @foreach ($products as $index => $product )
                      <tr>
                        <th scope="row">{{ $index +1 }}</th>
                        <td style="max-width:400px">{{ $product->ProductName }}</td>
                        <td>
                          <img class="img-fluid" style="height: 100px; width:100px" src="{{ $product->ImageURL }}" alt="Ảnh sản phẩm {{ $index+1 }}"/>
                        </td>
                        <td>{{ $product->category->CategoryName }}</td>
                        <td>{{ $product->brand->BrandName }}</td>
                        <td>{{ number_format($product->Price, 0, ',', '.') }}₫</td>
                        <td>{{ $product->StockQuantity }}</td>
                        <td class="text-center" style="max-width: 200px">
                          <a  href="/admin/products/{{ $product->ProductID }}" class="btn btn-sm btn-dark">Detail</a>
                          <a  href="/admin/products/{{ $product->ProductID }}/edit" class="btn btn-sm btn-primary">Update</a>
                          <form method="post" action="/admin/products/{{ $product->ProductID }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
        </div>
        </div>
    </div>


   
@endsection

