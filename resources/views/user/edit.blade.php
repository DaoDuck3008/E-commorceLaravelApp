@extends('admin.app')

@section('content')

    <div class="row g-3 mt-1">
        <div class="col-md-12" >
            <div class="card-custom">
                <h3 class="mb-4 text-danger">Chỉnh sửa danh mục</h3>
                <form action="/admin/user/{{ $user->UserID }}" method="post">
                @csrf
                @method('PUT')
                    <div class="row">
                        <!-- Tên danh mục -->
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">Tên người dùng</label>
                            <input
                            type="text"
                            class="form-control"
                            value="{{ $user->FullName }}"
                            name="name"
                            required
                            />
                        </div>

                        {{-- Role --}}
                        <div class="col-6 mb-3">
                            <label for="role" class="form-label">Quyền</label>
                            <select name="role" class="form-select">
                                <option value="{{ $user->Role }}" selected>{{ $user->Role }}</option>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Email -->
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input
                            type="email"
                            class="form-control"
                            value="{{ $user->Email }}"
                            name="email"
                            disabled
                            />
                        </div>
                        <!-- Phone number -->
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">Số điện thoại</label>
                            <input
                            type="text"
                            class="form-control"
                            value="{{ $user->PhoneNumber }}"
                            name="phone"
                            required
                            />
                        </div>
                    </div>

                    <!-- Adress -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Địa chỉ</label>
                        <input
                        type="text"
                        class="form-control"
                        value="{{ $user->Adress }}"
                        name="address"
                        />
                    </div>

                    {{-- submit --}}
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                          Sửa
                        </button>
                      </div>
                </form>
            </div>
        </div>
    </div>
@endsection

