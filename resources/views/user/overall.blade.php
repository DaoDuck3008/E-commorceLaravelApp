@extends('layouts.profileLayout')

@section('title')
    <title>Tổng quan tài khoản</title>
@endsection

@section('content')
  <!-- Header user info -->
  <div
    class="card-custom d-flex flex-column flex-md-row justify-content-between align-items-center gap-3"
  >
    <div class="d-flex align-items-center gap-3">
      <!-- Avatar -->
      <img
        src="https://anhcute.net/wp-content/uploads/2024/08/Hinh-anh-chibi-chuot-lang-nuoc-ngoi-thien.jpg"
        alt="Avatar"
        class="rounded-circle"
        width="70"
        height="70"
      />
      <div>
        <h5 class="fw-bold mb-1">{{ $user->FullName }}</h5>
        <span class="badge bg-danger me-1">S-MEM</span>
        <span class="badge bg-success">{{ $user->Role }}</span>
        <p class="mb-0 text-muted">Cập nhật lại sau 01/01/2026</p>
      </div>
    </div>
    <div class="text-center text-md-end">
      <h6 class="mb-1">Tổng số đơn đã mua: <strong>1</strong></h6>
      <h6 class="mb-0">
        Tổng tiền tích lũy:
        <strong class="text-danger">17.942.000đ</strong>
      </h6>
    </div>
  </div>

  <div class="card-custom quick-access">
    <div class="item">
      <i class="bi bi-star-fill"></i>
      <p class="mb-0 fw-semibold">Hạng thành viên</p>
    </div>
    <div class="item">
      <i class="bi bi-ticket-perforated"></i>
      <p class="mb-0 fw-semibold">Mã giảm giá</p>
    </div>
    <div class="item">
      <i class="bi bi-bag-check-fill"></i>
      <p class="mb-0 fw-semibold">Lịch sử mua hàng</p>
    </div>
    <div class="item">
      <i class="bi bi-geo-alt-fill"></i>
      <p class="mb-0 fw-semibold">Sổ địa chỉ</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card-custom">
        <h6 class="fw-bold mb-3">
          <i class="bi bi-box-seam"></i> Đơn hàng gần đây
        </h6>
        <div id="orders-container"></div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-custom text-center">
        <img
          src="https://cdn-icons-png.flaticon.com/512/992/992651.png"
          class="img-fluid mb-3"
          width="80"
        />
        <p class="mb-2 text-muted">Bạn chưa có ưu đãi nào.</p>
        <a href="#" class="btn btn-outline-danger btn-sm px-3"
          >Xem sản phẩm</a
        >
      </div>
    </div>
  </div>
@endsection

@section('script')
<script>
  // Gọi 5 order gần nhất bằng API
  function fetchOrders() {
    fetch('{{ route('api.order.history') }}') 
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(orders => {
            renderOrders(orders);
        })
        .catch(error => {
            console.error('Error fetching orders:', error);
            document.getElementById('orders-container').innerHTML = `
                <div class="alert alert-danger">
                    Có lỗi xảy ra khi tải đơn hàng. Vui lòng thử lại sau.
                </div>
            `;
        });
  }
  
  function renderOrders(orders) {
    const container = document.getElementById('orders-container');
    
    // Kiểm tra nếu orders không phải là array
    if (!Array.isArray(orders)) {
        container.innerHTML = `
            <div class="alert alert-danger">
                Dữ liệu đơn hàng không hợp lệ
            </div>
        `;
        return;
    }
    
    if (orders.length === 0) {
        container.innerHTML = `
            <div class="alert alert-info">
                Bạn chưa có đơn hàng nào.
            </div>
        `;
        return;
    }
    
    let html = '';
    
    orders.forEach((order, index) => {
        if(index > 4){
          html += `
            <div class="d-flex justify-content-center">
              <a class="btn btn-danger" href="{{ route('order.history') }}">Xem thêm</a>
            </div>
          `;

          container.innerHTML = html;

          return;
        }

        let statusBadge = '';
        switch(order.STATUS) {
            case 'Pending':
                statusBadge = '<span class="badge bg-warning">Chờ xác nhận</span>';
                break;
            case 'Confirmed':
                statusBadge = '<span class="badge bg-primary">Đã xác nhận</span>';
                break;
            case 'Shipped':
                statusBadge = '<span class="badge bg-info">Đang được giao</span>';
                break;
            case 'Completed':
                statusBadge = '<span class="badge bg-success">Đã hoàn thành</span>';
                break;
            case 'Cancelled':
                statusBadge = '<span class="badge bg-danger">Đã được hủy</span>';
                break;
            default:
                statusBadge = '';
        }
        
        let orderItemsHtml = '';
        order.orderitems.forEach((item, itemIndex) => {
            if (itemIndex > 1) {
                orderItemsHtml += '<p>...</p>';
                return;
            }
            orderItemsHtml += `<p>${itemIndex + 1}. ${item.product.ProductName}</p>`;
        });
        
        html += `
            <div class="order-item mb-3 p-3 border rounded">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong class="mb-2">Đơn hàng #0${243422408000131 + order.OrderID}</strong> - ${order.OrderDate}
                    </div>
                    <a href="/order/${order.OrderID}" class="btn btn-dark">Xem chi tiết</a>
                </div>
                <div class="mb-2">
                    ${orderItemsHtml}
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    ${statusBadge}
                    <span class="fw-bold text-danger">${formatCurrency(order.TotalAmount)}</span>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
  }

  // Hàm định dạng tiền tệ
  function formatCurrency(amount) {
      return new Intl.NumberFormat('vi-VN', { 
          style: 'currency', 
          currency: 'VND' 
      }).format(amount);
  }

  // Gọi hàm fetch orders khi trang tải xong
  document.addEventListener('DOMContentLoaded', function() {
      fetchOrders();
  });

</script>
@endsection