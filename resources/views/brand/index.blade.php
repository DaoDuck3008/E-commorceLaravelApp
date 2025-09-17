@extends('admin.app')

@section('title')
  <title>Quản lý thương hiệu</title>
@endsection

@section('content')
    <!-- Topbar -->
    <div class="topbar">
      <form action="{{ route('admin.brand.search') }}" method="get" class="w-50">
      @csrf
        <div class="d-flex align-items-center">
          <label  class="text-danger"><strong><i class="fa-solid fa-magnifying-glass me-3"></i></strong></label>
          <input
            type="text"
            class="form-control me-2"
            name="input"
            placeholder="Tìm kiếm theo tên thương hiệu"
          />
          <a href="/admin/brand" class="btn btn-danger">
            <strong>X</strong>
          </a>
        </div>
        
      </form>
      
    </div>
    <div class="row g-3 mt-2">
        <div class="col-md-12">
        <div class="card-custom" >
            <div class="d-flex my-2 ">
              <h4 class="me-auto text-danger" style="font-weight: 600"><i class="fa-solid fa-copyright me-2"></i>Bảng danh mục thương hiệu</h4>
              <a href="/admin/brand/create" class="btn btn-success">thêm thương hiệu mới</a>
            </div>
            <div class="table-responsive rounded " style="max-height: 700px; overflow-y: auto; overflow-x:auto">
                <table class="table table-hover align-middle">
                  <thead class="table-danger sticky-top" >
                    <tr >
                      <th scope="col">#</th>
                      <th scope="col">Brand</th>
                      <th scope="col">Category</th>
                      <th scope="col">Description</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody >
                    @foreach ($brands as $index => $brand )
                      <tr>
                        <th scope="row">{{ $index +1 }}</th>
                        <td>{{ $brand->BrandName }}</td>
                        <td>{{ $brand->categories->CategoryName }}</td>
                        <td class="text-truncate " style="white-space: nowrap; oveflow-x: scroll; max-width: 300px ">{{ $brand->Description }}</td>
                        <td class="d-flex gap-1">
                          <a  href="/admin/brand/{{ $brand->BrandID }}/edit" class="btn btn-sm btn-primary">Update</a>
                          <form method="post" action="/admin/brand/{{ $brand->BrandID }}">
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

