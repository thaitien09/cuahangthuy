@extends('layout')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Thêm danh mục</h2>
        <form action="{{ route('categories.store') }}" method="POST" class="card p-4 shadow-sm">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" name="name" placeholder="Nhập tên danh mục" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" placeholder="Mô tả danh mục" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Thêm mới</button>
        </form>
    </div>
@endsection
