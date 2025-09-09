@extends('admin.app')

@section('content')
    <!-- Topbar -->
    <div class="topbar">
      <input
        type="text"
        class="form-control w-25"
        placeholder="Tìm kiếm..."
      />
      
    </div>
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

    <div class="row g-3 mt-2">
        <div class="col-md-12">
        <div class="card-custom" >
            <div class="d-flex my-2 ">
              <h4 class="me-auto text-danger">Bảng danh mục sản phẩm</h4>
              <a href="/admin/category/create" class="btn btn-success">Thêm mới danh mục</a>
            </div>
            <div class="table-responsive rounded " >
                <table class="table  align-middle">
                  <thead class="table-danger sticky-top" >
                    <tr >
                      <th scope="col">#</th>
                      <th scope="col">Category</th>
                      <th scope="col">Description</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody  style="max-height: 400px; overflow-y: auto; overflow-x:auto">
                    @foreach ($categories as $index => $category )
                      <tr>
                        <th scope="row">{{ $index +1 }}</th>
                        <td>{{ $category->CategoryName }}</td>
                        <td class="text-truncate " style="white-space: nowrap; oveflow-x: scroll; max-width: 300px ">{{ $category->Description }}</td>
                        <td class="d-flex gap-1">
                          <a  href="/admin/category/{{ $category->CategoryID }}/edit" class="btn btn-sm btn-primary">Update</a>
                          <form method="post" action="/admin/category/{{ $category->CategoryID }}">
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

