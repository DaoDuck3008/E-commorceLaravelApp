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
    <!-- Cards -->
    <div class="row g-3">
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng sản phẩm</h6>
            <h3>1,250</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Người dùng</h6>
            <h3>3,450</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Mã giảm giá</h6>
            <h3>120</h3>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Đơn hàng</h6>
            <h3>980</h3>
        </div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-12">
        <div class="card-custom" >
            <div class="d-flex my-2 ">
              <h4 class="me-auto text-danger">Bảng Tài khoản</h4>
            </div>
            <div class="table-responsive rounded " >
                <table class="table  align-middle">
                  <thead class="table-danger sticky-top" >
                    <tr >
                      <th scope="col">#</th>
                      <th scope="col">Full Name</th>
                      <th scope="col">Role</th>
                      <th scope="col">Email</th>
                      <th scope="col">Phone Number</th>
                      <th scope="col">Adress</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody  style="max-height: 400px; overflow-y: auto; overflow-x:auto">
                    @foreach ($users as $index => $user )
                      <tr>
                        <th scope="row">{{ $index +1 }}</th>
                        <td>{{ $user->FullName }}</td>
                        <td>{{ $user->Role }}</td>
                        <td>{{ $user->Email }}</td>
                        <td>{{ $user->PhoneNumber }}</td>
                        <td class="text-truncate " style="white-space: nowrap; oveflow-x: scroll; max-width: 300px ">{{ $user->Address }}</td>
                        <td class="d-flex gap-1">
                          <a  href="/admin/user/{{ $user->UserID }}/edit" class="btn btn-sm btn-primary">Update</a>
                          <form method="post" action="/admin/user/{{ $user->UserID }}"  onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
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
@endsection

