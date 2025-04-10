@extends('layout')  <!-- Kế thừa layout của admin -->
@section('title', 'Thêm người dùng') <!-- Tiêu đề của trang -->
@section('content') <!-- Phần nội dung của trang -->

<div class="container">
    <h1 class="my-4">Thêm người dùng mới</h1>
    
    <!-- Hiển thị thông báo nếu có -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Form thêm người dùng -->
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Tên -->
        <div class="mb-3">
            <label for="name" class="form-label">Tên</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required minlength="2" maxlength="255">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Số điện thoại -->
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required pattern="[0-9]{10,15}">
            <small class="form-text text-muted">Nhập số điện thoại từ 10-15 ký tự số</small>
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Mật khẩu -->
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required minlength="8">
            <small class="form-text text-muted">Mật khẩu phải có ít nhất 8 ký tự</small>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Xác nhận mật khẩu -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Quyền -->
        <div class="mb-3">
            <label for="role" class="form-label">Quyền</label>
            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                <option value="">-- Chọn quyền --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Người dùng</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Nhân viên</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Ảnh đại diện -->
        <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
            <small class="form-text text-muted">Chấp nhận file hình ảnh (jpg, png, gif, v.v...)</small>
            @error('avatar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Nút submit và quay lại -->
        <button type="submit" class="btn btn-primary">Thêm người dùng</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection