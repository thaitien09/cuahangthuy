@extends('layout')

@section('title', 'Quản lý Loại sản phẩm')

@section('content')
<div class="container">
    <h2>Quản lý Loại sản phẩm</h2>
    <a href="{{ route('types.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Danh mục</th>
                <th>Tên Loại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($types as $type)
                <tr>
                <td>{{ $type->category_name }}</td>

                    <td>{{ $type->name }}</td>
                    <td>
                        <a href="{{ route('types.edit', $type->id) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('types.destroy', $type->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
