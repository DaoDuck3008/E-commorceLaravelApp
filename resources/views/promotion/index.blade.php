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
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4 shadow-sm">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="shadow-primary border-radius-lg pt-4 pb-3 d-flex">
                            <h4 class="me-auto text-danger"><strong><i class="fa-solid fa-ticket me-2"></i> Quản lý khuyến mãi</strong></h4>
                            <a href="{{ route('promotion.create') }}" class="btn btn-success mb-3 float-end">Thêm Khuyến Mãi Mới</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="p-3">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive p-0" style="max-height: 500px;">
                            <table class="table table-hover align-middle mx-2" style="min-width: 1200px;">
                                <thead class="table-danger" style="position: sticky; top: 0; z-index: 10;">
                                    <tr>
                                        <th class="text-uppercase text-dark text-xxs font-weight-bolder">ID</th>
                                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Tiêu đề</th>
                                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Giảm giá (%)</th>
                                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Ngày bắt đầu</th>
                                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Ngày kết thúc</th>
                                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Hình ảnh</th>
                                        <th class="text-secondary opacity-7">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promotions as $promotion)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-xs">{{ $promotion->PromotionID }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $promotion->Title }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $promotion->DiscountPercent }}%</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $promotion->StartDate }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $promotion->EndDate }}</p>
                                            </td>
                                        <td>
                                            {{-- Hiển thị hình ảnh từ đường dẫn lưu trữ --}}
                                            <img src="{{ $promotion->ImgURL}}" alt="Hình ảnh khuyến mãi" style="width: 100px; height: auto;">
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('promotion.edit', $promotion->PromotionID) }}" class="btn btn-sm btn-warning text-white font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                    Sửa
                                                </a>
                                                <form action="{{ route('promotion.destroy', $promotion->PromotionID) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger font-weight-bold text-xs" onclick="return confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?');">Xóa</button>
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
        </div>
    </div>

@endsection