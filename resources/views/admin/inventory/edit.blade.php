@extends('layout')

@section('title', 'Chỉnh sửa nhập kho')

@section('content')
<div class="container">
    <h2 class="mt-4">Chỉnh sửa nhập kho</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
        </div>
    @endif

    <!-- Sử dụng POST cho cập nhật -->
    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
        @csrf
        <!-- Không dùng @method('PUT') vì chỉ dùng POST -->

        <div class="mb-3">
            <label for="product_id" class="form-label">Sản phẩm</label>
            <select name="product_id" id="product_id" class="form-select">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @if($product->id == $inventory->product_id) selected @endif>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng nhập</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity', $inventory->quantity) }}">
        </div>

        <div class="mb-3">
            <label for="supplier" class="form-label">Nhà cung cấp</label>
            <input type="text" name="supplier" id="supplier" class="form-control" value="{{ old('supplier', $inventory->supplier) }}">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
