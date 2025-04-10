@extends('layout')

@section('content')
<h2>Quản lý bình luận</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Quyền</th> <!-- Hiển thị quyền chính xác -->
            <th>Sản phẩm</th>
            <th>Đánh giá</th>
            <th>Nội dung</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comments as $comment)
        <tr>
            <td>{{ $comment->id }}</td>
            <td>{{ $comment->user_name }}</td>
            <td>
                @if($comment->user_role == 'admin')
                    <span class="badge bg-danger">Admin</span>
                @elseif($comment->user_role == 'staff')
                    <span class="badge bg-warning text-dark">Nhân viên</span>
                @else
                    <span class="badge bg-success">Khách hàng</span>
                @endif
            </td>
            <td>{{ $comment->product_name ?? '---' }}</td>
            <td>{{ $comment->rating ?? '---' }}</td>
            <td>
                @if($comment->parent_id)
                    ↳ {{ $comment->content }}
                @else
                    <strong>{{ $comment->content }}</strong>
                @endif
            </td>
            <td>{{ date('d/m/Y H:i', strtotime($comment->created_at)) }}</td>
            <td>
                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                </form>
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
