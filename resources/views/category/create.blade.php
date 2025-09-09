@extends('admin.app')

@section('content')

    <div class="row g-3 mt-1">
        <div class="col-md-12" >
            <div class="card-custom">
                <h3 class="mb-4 text-danger">Thêm mới danh mục</h3>
                <form action="/admin/category" method="post">
                @csrf
                    <!-- Tên danh mục -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input
                        type="text"
                        class="form-control"
                        placeholder="Nhập tên danh mục"
                        name="name"
                        required
                        />
                    </div>

                    <!-- Mô tả danh mục -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả danh mục</label>
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

