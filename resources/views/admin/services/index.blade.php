@extends('layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Quản lý Dịch vụ</h2>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary mb-3">Thêm dịch vụ</a>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Tên dịch vụ</th>
                <th>Mô tả</th>
                <th>Giá (VNĐ)</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td>{{ $service->name }}</td>
                <td>{{ $service->description }}</td>
                <td>{{ number_format($service->price, 0, ',', '.') }} đ</td>
                <td>{{ $service->created_at }}</td>
                <td>
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
