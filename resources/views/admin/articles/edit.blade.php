@extends('layout')

@section('content')
    <h2>Chỉnh sửa bài viết</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="summary" class="form-label">Tóm tắt</label>
            <textarea class="form-control" id="summary" name="summary" rows="3" required>{{ old('summary', $article->summary) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Danh mục</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $article->category) }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea class="form-control" id="content" name="content" rows="6" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="thumbnail" class="form-label">Ảnh thumbnail</label>
            @if ($article->thumbnail)
                <div class="mb-2">
                <img src="{{ asset('images/' . $article->thumbnail) }}" alt="Thumbnail" width="150">
                </div>
            @endif
            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-control" id="status" name="status" required>
                <option value="nháp" {{ old('status', $article->status) == 'nháp' ? 'selected' : '' }}>Nháp</option>
                <option value="xuất bản" {{ old('status', $article->status) == 'xuất bản' ? 'selected' : '' }}>Xuất bản</option>
                <option value="lưu trữ" {{ old('status', $article->status) == 'lưu trữ' ? 'selected' : '' }}>Lưu trữ</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection

@section('scripts')
    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
