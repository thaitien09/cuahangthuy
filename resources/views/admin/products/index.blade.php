@extends('layout')

@section('content')
<div class="container">
    <h2>Danh Sách Sản Phẩm</h2>
    <div class="mb-3">
        <span class="badge bg-primary me-2">Tổng sản phẩm: {{ $totalProducts }}</span>
        <span class="badge bg-success me-2">Tổng danh mục: {{ $totalCategories }}</span>
        <span class="badge bg-info">Tổng loại: {{ $totalTypes }}</span>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="search_name" class="form-control" placeholder="Tìm theo tên" value="{{ request('search_name') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select">
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-select">
                                <option value="">Chọn loại</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="price_sort" class="form-select">
                                <option value="">Sắp xếp giá</option>
                                <option value="asc" {{ request('price_sort') == 'asc' ? 'selected' : '' }}>Giá thấp -> cao</option>
                                <option value="desc" {{ request('price_sort') == 'desc' ? 'selected' : '' }}>Giá cao -> thấp</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Reset</a>
                            <a href="{{ route('products.create') }}" class="btn btn-success">Thêm Sản Phẩm</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Sản Phẩm</th>
                <th>Danh Mục</th>
                <th>Loại Sản Phẩm</th>
                <th>Giá Mua</th>
                <th>Giá Bán</th>             
                <th>Mô Tả</th>
                <th>Hình Ảnh</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category_name ?? 'Không có danh mục' }}</td>
                <td>{{ $product->type_name ?? 'Không có loại' }}</td>
                <td>{{ number_format($product->purchase_price) }} VNĐ</td>
                <td>{{ number_format($product->sale_price) }} VNĐ</td>
                <td>{{ Str::limit($product->description, 50) }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" width="50" alt="Product Image">
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf                   
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Phân trang với Bootstrap 5 -->
    <div class="d-flex justify-content-center">
        {!! $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') !!}
    </div>
</div>
@endsection