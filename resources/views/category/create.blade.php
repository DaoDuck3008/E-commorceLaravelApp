@extends('admin.app')

@section('content')

    <div class="row g-3 mt-1">
        <div class="col-md-12" >
            <div class="card-custom">
                <h3 class="mb-4 text-danger">Thêm mới danh mục</h3>
                <form action="/admin/category" method="post">
                @csrf
                    <div class="row">
                        <!-- Tên danh mục -->
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label"><strong>Tên danh mục hàng</strong></label>
                            <input
                            type="text"
                            class="form-control"
                            placeholder="Nhập tên danh mục"
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
                            placeholder="Nhập icon danh mục"
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
                        <label for="description" class="form-label"><strong>Mô tả danh mục hàng</strong></label>
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
                        <a href="/admin/category" class="btn btn-dark px-4">
                            Hủy
                        </a>
                        <button type="submit" class="btn btn-danger px-4">
                          Thêm mới 
                        </button>
                      </div>
                </form>
            </div>
        </div>
    </div>
@endsection

