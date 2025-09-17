@extends('admin.app')

@section('title')
  <title>Quản lý tài khoản</title>
@endsection

@section('style')
  <style>
    .icon{
      border-radius: 50% ;
      
    }
  </style>
@endsection

@section('content')
    <!-- Cards -->
    <div class="row g-3 mb-3">
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng số tài khoản</h6>
            <div class="d-flex justify-content-between">
              <h3>{{ $users->count() }}</h3>
              <h3 class="icon bg-secondary px-2 py-1"><i class="fa-solid fa-users text-white"></i></h3>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng số tài khoản khách</h6>
            <div class="d-flex justify-content-between">
              <h3>{{ $users->first()->getTotalCustomer() }}</h3>
              <h3 class="icon bg-info px-2 py-1"><i class="fa-solid fa-user text-white"></i></h3>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng số tài khoản nhân viên</h6>
            <div class="d-flex justify-content-between">
              <h3>{{ $users->first()->getTotalStaff() }}</h3>
              <h3 class="icon bg-warning px-2 py-1"><i class="fa-solid fa-user-tie text-white"></i></h3>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card-custom">
            <h6>Tổng số tài khoản Admin</h6>
            <div class="d-flex justify-content-between">
              <h3>{{ $users->first()->getTotalAdmin() }}</h3>
              <h3 class="icon bg-danger px-2 py-1"><i class="fa-solid fa-user-nurse text-white"></i></h3>
            </div>
        </div>
        </div>
    </div>

    <!-- Topbar -->
    <div class="topbar">
      <form action={{ route('admin.user.search') }} method="get" class="d-flex align-items-center">
      @csrf
      <label class="text-danger"><strong><i class="fa-solid fa-magnifying-glass me-3"></i></strong></label>
      <input
        type="text"
        class="form-control me-3"
        name="input"
        placeholder="Tìm kiếm tên người dùng"
      />
      <a href="/admin/user" class="btn btn-danger">
        <strong>X</strong>
      </a>
      </form>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-12">
        <div class="card-custom" >
            <div class="d-flex my-2 ">
              <h4 class="me-auto text-danger" style="font-weight: 600"><i class="fa-solid fa-users me-2"></i> Bảng người dùng</h4>
            </div>
            <div class="table-responsive rounded" style="max-height: 700px; overflow-y: auto; overflow-x:auto">
                <table class="table table-hover align-middle">
                  <thead class="table-danger sticky-top" >
                    <tr >
                      <th scope="col">#</th>
                      <th scope="col">Tên người dùng</th>
                      <th scope="col"  class="text-center">Chức vụ</th>
                      <th scope="col">Email</th>
                      <th scope="col">Số điện thoại</th>
                      <th scope="col">Địa chỉ</th>
                      <th scope="col">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody  style="max-height: 400px; overflow-y: auto; overflow-x:auto">
                    @foreach ($users as $index => $user )
                      <tr>
                        <th scope="row">{{ $index +1 }}</th>
                        <td>{{ $user->FullName }}</td>
                        <td class="text-center">
                          @switch($user->Role)
                            @case('Admin')
                              <span class="badge bg-danger">{{ $user->Role }}</span>
                              @break
                            @case('Staff')
                              <span class="badge bg-warning">{{ $user->Role }}</span>
                              @break
                            @case('Customer')
                              <span class="badge bg-info">{{ $user->Role }}</span>
                              @break
                            @default
                            <span class="badge bg-info">{{ $user->Role }}</span>
                          @endswitch
                        </td>
                        <td>{{ $user->Email }}</td>
                        <td>{{ $user->PhoneNumber }}</td>
                        <td class="text-truncate " style="white-space: nowrap; oveflow-x: scroll; max-width: 300px ">{{ $user->Address }}</td>
                        <td class="d-flex gap-1">
                          <a  href="/admin/user/{{ $user->UserID }}/edit" class="btn btn-sm btn-primary">Sửa</a>
                          <form method="post" action="/admin/user/{{ $user->UserID }}"  onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
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

