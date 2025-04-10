@extends('layout')

@section('title', 'Thêm Người Dùng')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Người Dùng</h2>

    <!-- Hiển thị thông báo -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form để thêm người dùng mới -->
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Tên:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Xác nhận mật khẩu:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="form-group mb-3">
            <label for="role">Vai trò:</label>
            <select class="form-control" id="role" name="role" required>
                <option value="admin">Quản trị viên</option>
                <option value="customer">Khách hàng</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="avatar">Ảnh đại diện:</label>
            <input type="file" class="form-control" id="avatar" name="avatar">
        </div>

        <button type="submit" class="btn btn-primary">Thêm Người Dùng</button>
    </form>
</div>
@endsection
