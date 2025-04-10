@extends('layout')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Chỉnh sửa danh mục</h2>
        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="card p-4 shadow-sm">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control">{{ $category->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
