@extends('layout')

@section('title', 'Chỉnh sửa Loại sản phẩm')

@section('content')
<div class="container">
    <h2>Chỉnh sửa Loại sản phẩm</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf


        <div class="mb-3">
            <label for="name" class="form-label">Tên Loại</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $type->name }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Chọn Danh mục</label>
            <select class="form-control" id="category_id" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $type->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
