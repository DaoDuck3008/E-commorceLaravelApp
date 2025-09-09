@extends('admin.app')

@section('content')

    <div class="row g-3 mt-1">
        <div class="col-md-12" >
            <div class="card-custom">
                <h3 class="mb-4 text-danger">Chỉnh sửa danh mục</h3>
                <form action="/admin/category/{{ $category->CategoryID }}" method="post">
                @csrf
                @method('PUT')
                    <!-- Tên danh mục -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input
                        type="text"
                        class="form-control"
                        value="{{ $category->CategoryName }}"
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
                        name="description"
                        rows="5"
                        required
                        >{{ $category->Description }}</textarea>
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

