@extends('layout')

@section('title', 'Quản lý kho hàng')

@section('content')
<div class="container">
    <h2 class="mt-4">Danh sách kho hàng</h2>
    <a href="{{ route('inventory.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nhập hàng mới
    </a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('inventory.index') }}" class="mb-3 d-flex align-items-center">
        <input type="text" name="search" class="form-control w-auto me-2" placeholder="Tìm sản phẩm" value="{{ request('search') }}">

        <select name="supplier" class="form-select w-auto me-2">
            <option value="">Tất cả nhà cung cấp</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->supplier }}" {{ request('supplier') == $supplier->supplier ? 'selected' : '' }}>
                    {{ $supplier->supplier }}
                </option>
            @endforeach
        </select>

        <select name="stock" class="form-select w-auto me-2">
            <option value="">Tất cả</option>
            <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Sắp hết hàng</option>
            <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Hết hàng</option>
            <option value="new" {{ request('stock') == 'new' ? 'selected' : '' }}>Mới</option>
        </select>

        <button type="submit" class="btn btn-primary">Lọc</button>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Hình ảnh</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Nhà cung cấp</th>
                <th>Ngày nhập</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $inventory)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($inventory->product_image)
                            <img src="{{ asset('images/' . $inventory->product_image) }}" alt="{{ $inventory->product_name }}" style="width:50px; height:auto;">
                        @else
                            <span>Không có hình</span>
                        @endif
                    </td>
                    <td>{{ $inventory->product_name }}</td>
                    <td>
                        @if($inventory->quantity > 0 && $inventory->quantity == 10)
                            <span class="badge bg-warning text-dark">Sắp hết hàng ({{ $inventory->quantity }})</span>
                        @elseif($inventory->quantity <= 0)
                            <span class="badge bg-danger text-white">Hết hàng</span>
                        @else
                            <span class="badge bg-success text-white">Mới ({{ $inventory->quantity }})</span>
                        @endif
                    </td>
                    <td>{{ $inventory->supplier }}</td>
                    <td>{{ \Carbon\Carbon::parse($inventory->created_at)->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
    {{ $inventories->links('pagination::bootstrap-5') }}
</div>

</div>
@endsection
