@extends('admin.app')

@section('content')

    <div class="row g-3 mt-1">
        <div class="col-md-12" >
            <div class="card-custom">
                <h3 class="mb-4 text-danger">Chỉnh sửa danh mục</h3>
                <form action="/admin/category/{{ $category->CategoryID }}" method="post">
                @csrf
                @method('PUT')
                    <div class="row">
                        <!-- Tên danh mục -->
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input
                            type="text"
                            class="form-control"
                            value="{{ $category->CategoryName }}"
                            name="name"
                            required
                            />
                        </div>

                        {{-- Icon danh mục --}}
                        <div class="mb-3 col-md-6">
                            <label for="icon" class="form-label"><strong>Icon danh mục</strong></label>
                            <input
                            type="text"
                            class="form-control mb-2"
                            value="{{ $category->Icon }}"
                            name="icon"
                            required
                            />
                            <div class="d-flex flex-column">
                                <span><i>Lưu ý: tên Icon phải được nhập đúng theo tên icon đó trên FontAwesome</i></span>
                                <span><i>Ví dụ: Icon <i class="fa-solid fa-house"></i> có tên là <strong>fa-house</strong> thì bạn nhập là <trong>house</trong></i></span>
                            </div>
                        </div>
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
                        <a href="/admin/category" class="btn btn-dark px-4">
                            Hủy
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                          Sửa
                        </button>
                      </div>
                </form>
            </div>
        </div>
    </div>
@endsection

