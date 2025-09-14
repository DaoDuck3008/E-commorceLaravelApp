@extends('admin.app')

@section('content')
    
    <!-- Cards -->
    <div class="row g-3 mb-3">
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng số đơn hàng</h6>
            <h3>{{ $orders->count() }}</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Số lượng đơn hàng trong mỗi đơn</h6>
            <h3>{{ $orderitems->count() }}</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng doanh thu</h6>
            <h3>{{number_format($orders->first()->getTotalRevenue(),0,',','.')}} VNĐ</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng doanh thu trong ngày</h6>
            <h3>{{number_format($orders->first()->getTodayRevenue(),0,',','.')}} VNĐ</h3>
        </div>
        </div>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <input
            type="text"
            class="form-control w-25"
            placeholder="Tìm kiếm..."
        />
    </div>

    <div class="row g-3 ">
        <div class="col-md-12">
        <div class="card-custom">
            <div class="d-flex my-2 ">
              <h4 class="me-auto text-danger">Bảng đơn hàng</h4>
            </div>
            <div class="table-responsive rounded" style="max-height: 500px;">
                <table class="table table-hover align-middle" style="min-width: 1200px;">
                    <thead class="table-danger" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th scope="col" style="white-space: nowrap;">#</th>
                            <th scope="col" style="white-space: nowrap;">Mã đơn hàng</th>
                            <th scope="col" style="white-space: nowrap;">Ngày đặt</th>
                            <th scope="col" style="white-space: nowrap;">Người đặt</th>
                            <th scope="col" style="white-space: nowrap;">Trạng thái</th>
                            <th scope="col" style="white-space: nowrap;">Tổng giá</th>
                            <th scope="col" style="white-space: nowrap;">Số lượng</th>
                            <th scope="col" style="white-space: nowrap;">Phương thức thanh toán</th>
                            <th scope="col" style="white-space: nowrap; min-width: 200px;">Địa chỉ giao</th>
                            <th scope="col" style="white-space: nowrap;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody style="max-height: 400px; overflow-y: auto;">
                        @foreach ($orders as $index => $order )
                        <tr>
                            <td style="white-space: nowrap;">{{ $index +1 }}</td>
                            <td style="white-space: nowrap;">#0{{ 243422408000131 + $order->OrderID }}</td>
                            <td style="white-space: nowrap;">{{ $order->OrderDate->format('d/m/Y H:i') }}</td>
                            <td style="white-space: nowrap;">{{ $order->user->FullName }}</td>
                            <td class="text-center align-middle" style="white-space: nowrap;">
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
                            </td>
                            <td style="white-space: nowrap;"><span class="float-end fw-bold">{{ number_format($order->TotalAmount, 0, ',', '.') }}đ</span></td>
                            <td class="text-center align-middle" style="white-space: nowrap;"><span>{{ $order->orderitems()->count() }}</span></td>
                            <td class="text-center align-middle" style="white-space: nowrap;">
                                @switch($order->payments->first()->PaymentMethod)
                                    @case('COD')
                                        <span class="badge bg-info">Thanh toán khi giao</span>
                                        @break
                                    @case('BankTransfer')
                                        <span class="badge bg-success">Thanh toán chuyển khoản</span>
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td style="min-width: 200px; max-width: 300px; word-wrap: break-word;">{{ $order->ShippingAddress }}</td>
                            <td style="white-space: nowrap;">
                                <a href="{{ route('admin.order.detail',$order->OrderID) }}" class="btn btn-dark btn-sm">Detail</a>
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