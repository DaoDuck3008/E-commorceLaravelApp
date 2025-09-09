@extends('admin.app')

@section('content')
    <!-- Cards -->
    <div class="row g-3">
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng sản phẩm</h6>
            <h3>1,250</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Người dùng</h6>
            <h3>3,450</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Mã giảm giá</h6>
            <h3>120</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Đơn hàng</h6>
            <h3>980</h3>
        </div>
        </div>
    </div>

    <!-- Topbar -->
    @include('components.search.productDasboard')

    <div class="row g-3 ">
        <div class="col-md-12">
        <div class="card-custom">
            <div class="d-flex my-2 ">
              <h4 class="me-auto">Biểu đồ hàng hóa</h4>
              <a href="admin/products/create" class="btn btn-success">Thêm mới sản phẩm</a>
            </div>
            <div class="table-responsive rounded " >
                <table class="table  align-middle " >
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

