@extends('admin.app')

@section('title')
  <title>Quản lý thương hiệu</title>
@endsection

@section('content')
    <div class="row g-3 mt-1">
        <div class="col-md-12" >
            <div class="card-custom">
                <h3 class="mb-4 text-danger">Thêm mới Thương hiệu</h3>
                <form action="/admin/brand" method="post">
                @csrf
                    <!-- Tên danh mục -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên thương hiệu</label>
                        <input
                        type="text"
                        class="form-control"
                        placeholder="Nhập tên danh mục"
                        name="name"
                        required
                        />
                    </div>

                    <div class="mb-3">
                        <select class="form-select" name="categoryID" required>
                            @foreach ($categories as $category )
                                <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mô tả danh mục -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả thương hiệu</label>
                        <textarea
                        type="text"
                        class="form-control"
                        placeholder="Nhập mô tả cho danh mục, ví dụ: Bao gồm các thiết bị điện tử và phụ kiện"
                        name="description"
                        rows="5"
                        required
                        ></textarea>
                    </div>

                    {{-- submit --}}
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-danger px-4">
                          Thêm mới 
                        </button>
                      </div>
                </form>
            </div>
        </div>
    </div>
@endsection

