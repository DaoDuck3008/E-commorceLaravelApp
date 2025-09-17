@extends('admin.app') {{-- Đây là layout bạn đã dùng trong các file khác --}}

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card my-4 shadow-sm">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h4 class="me-auto text-danger">Chỉnh Sửa Khuyến Mãi</h4>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="p-3">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('promotion.update', $promotion->PromotionID) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="Title" class="form-label">Tiêu đề:</label>
                                <input type="text" name="Title" class="form-control" value="{{ $promotion->Title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="Description" class="form-label">Mô tả:</label>
                                <textarea name="Description" class="form-control" rows="3">{{ $promotion->Description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="DiscountPercent" class="form-label">Giảm giá (%):</label>
                                <input type="number" name="DiscountPercent" class="form-control" value="{{ $promotion->DiscountPercent }}" step="0.01">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="StartDate" class="form-label">Ngày bắt đầu:</label>
                                    <input type="date" name="StartDate" class="form-control" value="{{ $promotion->StartDate }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="EndDate" class="form-label">Ngày kết thúc:</label>
                                    <input type="date" name="EndDate" class="form-control" value="{{ $promotion->EndDate }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ImgURL" class="form-label">Hình ảnh:</label>
                                {{-- Hiển thị ảnh hiện tại --}}
                                @if ($promotion->ImgURL)
                                    <img src="{{ asset('ads/' .$promotion->ImgURL) }}" alt="Hình ảnh hiện tại" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                                @endif
                                {{-- Input để tải ảnh mới --}}
                                <input type="file" name="Img" accept="image/*" class="form-control"/>
                                <small class="text-muted">Để trống nếu không muốn thay đổi hình ảnh.</small>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Cập nhật Khuyến Mãi</button>
                            <a href="{{ route('promotion.index') }}" class="btn btn-secondary mt-3">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection