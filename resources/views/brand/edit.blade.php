@extends('admin.app')

@section('title')
  <title>Quản lý thương hiệu</title>
@endsection

@section('content')

    <div class="row g-3 mt-1">
        <div class="col-md-12" >
            <div class="card-custom">
                <h3 class="mb-4 text-danger">Chỉnh sửa thương hiệu</h3>
                <form action="/admin/brand/{{ $brand->BrandID }}" method="post">
                @csrf
                @method('PUT')
                    <!-- Tên thương hiệu -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên thương hiệu</label>
                        <input
                        type="text"
                        class="form-control"
                        value="{{ $brand->BrandName }}"
                        name="name"
                        required
                        />
                    </div>

                    {{-- Chọn loại danh mục --}}
                    <div class="mb-3">
                        <select class="form-select" name="categoryID" required>
                            <
                            @foreach ($categories as $category )
                                <option value="{{ $category->CategoryID }}" {{ $brand->categories->CategoryID == $category->CategoryID ? 'selected' : '' }}>{{ $category->CategoryName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mô tả danh mục -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả thương hiệu</label>
                        <textarea
                        type="text"
                        class="form-control"
                        name="description"
                        rows="5"
                        required
                        >{{ $brand->Description }}</textarea>
                    </div>

                    {{-- submit --}}
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                          Sửa
                        </button>
                      </div>
                </form>
            </div>
        </div>
    </div>
@endsection

