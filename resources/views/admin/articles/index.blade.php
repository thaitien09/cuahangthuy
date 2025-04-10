@extends('layout')

@section('content')
    <h2>Quản lý bài viết</h2>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">Thêm bài viết</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Tóm tắt</th>
                <th>Danh mục</th>
                <th>Lượt xem</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($article->summary, 50) }}</td>
                    <td>{{ $article->category }}</td>
                    <td>{{ $article->view_count }}</td>
                    <td>{{ $article->status }}</td>
                  <td>{{ \Carbon\Carbon::parse($article->created_at)->format('d/m/Y H:i') }}</td>
<td>{{ \Carbon\Carbon::parse($article->updated_at)->format('d/m/Y H:i') }}</td>

                    <td>
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
