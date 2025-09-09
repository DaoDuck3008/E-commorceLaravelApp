@extends('layouts.profileLayout')

@section('content')
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          
          <!-- Thông tin user -->
          <div class="card shadow-lg rounded-3">
            <div class="card-body p-4">
              <div class="d-flex align-items-center mb-4">
                <img src="https://anhcute.net/wp-content/uploads/2024/08/Hinh-anh-chibi-chuot-lang-nuoc-ngoi-thien.jpg" 
                     alt="Avatar" class="rounded-circle me-3" width="80" height="80">
                <div>
                  <h4 class="mb-0 fw-bold">{{auth()->user()->FullName}}</h4>
                  <span class="badge bg-success">Thành viên</span>
                  <span class="badge bg-danger">{{auth()->user()->Role}}</span>
                </div>
              </div>
    
              <!-- Thông tin chi tiết -->
              <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><i class="fa-solid fa-phone me-2 text-primary"></i> Số điện thoại</span>
                  <span class="fw-semibold">{{auth()->user()->PhoneNumber}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><i class="fa-solid fa-envelope me-2 text-primary"></i> Email</span>
                  <span class="fw-semibold">{{auth()->user()->Email}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><i class="fa-solid fa-location-dot me-2 text-primary"></i> Địa chỉ</span>
                  <span class="fw-semibold">{{auth()->user()->Address}}</span>
                </li>
              </ul>
    
              <!-- Nút -->
              <div class="text-end">
                <a class="btn btn-dark" href="/user/overall/{{auth()->user()->UserID}}">Quay lại</a>
                <a href="/user/edit/{{ auth()->user()->UserID }}" class="btn btn-danger">
                  <i class="fa-solid fa-pen-to-square me-1"></i> Thay đổi thông tin
                </a>
              </div>
            </div>
          </div>
    
        </div>
      </div>
    </div>
    
@endsection