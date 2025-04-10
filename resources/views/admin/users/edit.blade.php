@extends('layout') <!-- Kế thừa layout của admin -->

@section('title', 'Chỉnh sửa người dùng') <!-- Tiêu đề của trang -->

@section('content') <!-- Phần nội dung của trang -->
    <div class="container">
        <h1 class="my-4">Chỉnh sửa người dùng</h1>

        <!-- Thông báo nếu có -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form chỉnh sửa người dùng -->
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tên -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <!-- Số điện thoại -->
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
            </div>

            <!-- Quyền -->
            <div class="mb-3">
                <label for="role" class="form-label">Quyền</label>
                <select class="form-control" id="role" name="role">
                    <option value="admin" {{ isset($user) && $user->role == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                    <option value="user" {{ isset($user) && $user->role == 'user' ? 'selected' : '' }}>Người dùng</option>
                    <option value="staff" {{ isset($user) && $user->role == 'staff' ? 'selected' : '' }}>Nhân viên</option>
                </select>
            </div>

            <!-- Ảnh đại diện -->
            <div class="mb-3">
                <label for="avatar" class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" id="avatar" name="avatar">
            </div>

            <!-- Mật khẩu (nếu thay đổi) -->
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu mới (nếu thay đổi)">
            </div>

            <!-- Xác nhận mật khẩu (nếu thay đổi) -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu mới (nếu thay đổi)">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
