@extends('admin.app')

@section('title')
  <title>Quản lý danh mục hàng</title>
@endsection

@section('content')
    <div class="row g-3 mt-2">
        <div class="col-md-12">
        <div class="card-custom" >
            <div class="d-flex my-2 ">
              <h4 class="me-auto text-danger" style="font-weight: 600"><i class="fa-solid fa-layer-group me-2"></i>Bảng danh mục sản phẩm</h4>
              <a href="/admin/category/create" class="btn btn-success">Thêm mới danh mục</a>
            </div>
            <div class="table-responsive rounded " >
                <table class="table  align-middle">
                  <thead class="table-danger sticky-top" >
                    <tr >
                      <th scope="col">#</th>
                      <th scope="col">Danh mục hàng</th>
                      <th scope="col">Mô tả danh mục hàng</th>
                      <th scope="col">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody  style="max-height: 400px; overflow-y: auto; overflow-x:auto">
                    @foreach ($categories as $index => $category )
                      <tr>
                        <th scope="row">{{ $index +1 }}</th>
                        <td><i class="fa-icon fa-solid fa-{{ $category->Icon }} me-2"></i>{{ $category->CategoryName }}</td>
                        <td class="text-truncate " style="white-space: nowrap; oveflow-x: scroll; max-width: 300px ">{{ $category->Description }}</td>
                        <td class="d-flex gap-1">
                          <a  href="/admin/category/{{ $category->CategoryID }}/edit" class="btn btn-sm btn-primary">Sửa</a>
                          <form method="post" action="/admin/category/{{ $category->CategoryID }}" onsubmit="Bạn có chắc muốn xóa danh mục hàng này không?">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
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

