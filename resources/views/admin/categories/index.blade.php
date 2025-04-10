@extends('layout')

@section('content')
    <h2>Danh mục sản phẩm</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Thêm danh mục</a>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
</form>

                </td>
            </tr>
        @endforeach
    </table>
@endsection
