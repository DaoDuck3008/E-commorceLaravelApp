@extends('layouts.profileLayout')

@section('title')
    <title>Lịch sử đơn hàng</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card-custom">
        <h6 class="fw-bold mb-3">
          <i class="bi bi-box-seam"></i> Đơn hàng gần đây
        </h6>
        @if ($orders->isEmpty())
            <div class="text-center py-5">
                <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                <h1>Bạn chưa có đơn hàng nào!</h1>
                <p class="text-muted">Hãy mua sắm để xem đơn hàng tại đây</p>
                <a href="{{ route('home') }}" class="btn btn-danger">
                    <i class="fa-solid fa-shopping-cart me-2"></i>Mua sắm ngay
                </a>
            </div>
        @endif
        @foreach ($orders as $index => $order )
            <div class="order-item">
                <div>
                    <strong class="mb-2">Đơn hàng #0{{ 243422408000131 + $order->OrderID }}</strong> - {{ $order->OrderDate }}
                    <a href="{{ route('order.show',$order->OrderID) }}" class="float-end btn btn-dark me-1">Xem chi tiết</a>
                </div>
                <div class="">
                    @foreach ( $order->orderitems as $index => $item )
                        @if ($index > 1)
                            <p>...</p>
                            @break
                        @endif
                        <p> {{ $index+1 }}. {{ $item->product->ProductName }} </p> 
                    @endforeach
                </div>
                @switch($order->STATUS)
                    @case('Pending')
                        <span class="badge bg-warning">Chờ xác nhận</span>
                        @break
                    @case('Confirmed')
                        <span class="badge bg-primary">Đã xác nhận</span>
                        @break
                    @case('Shipped')
                        <span class="badge bg-info">Đang được giao</span>
                        @break
                    @case('Completed')
                        <span class="badge bg-success">Đã hoàn thành</span>
                        @break
                    @case('Cancelled')
                        <span class="badge bg-danger">Đã được hủy</span>
                        @break
                    @default
                @endswitch
                <span class="float-end fw-bold text-danger">{{ number_format($order->TotalAmount, 0, ',', '.') }}đ</span>
            </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
      </div>
    </div>
@endsection