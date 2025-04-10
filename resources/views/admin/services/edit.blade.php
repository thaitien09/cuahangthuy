@extends('layout')

@section('content')
    <h2>Chỉnh sửa Dịch vụ</h2>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tên Dịch vụ</label>
            <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" required>{{ $service->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" class="form-control" value="{{ $service->price }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
