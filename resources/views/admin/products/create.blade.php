@extends('layout')

@section('content')
<div class="container">
    <h2>Thêm Sản Phẩm</h2>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
   
   

        <!-- Tên Sản Phẩm -->
        <div class="mb-3">
            <label class="form-label">Tên Sản Phẩm</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <!-- Chọn Danh Mục -->
        <div class="mb-3">
            <label class="form-label">Danh Mục</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Chọn Danh Mục --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Chọn Loại Sản Phẩm (dựa vào Danh Mục đã chọn) -->
        <div class="mb-3">
            <label class="form-label">Loại Sản Phẩm</label>
            <select name="type_id" id="type_id" class="form-control" required>
                <option value="">-- Chọn Loại Sản Phẩm --</option>
                <!-- Các option sẽ được cập nhật dựa trên Danh Mục đã chọn -->
            </select>
        </div>

        <!-- Giá Mua -->
        <div class="mb-3">
            <label class="form-label">Giá Mua</label>
            <input type="number" name="purchase_price" class="form-control" required>
        </div>

        <!-- Giá Bán -->
        <div class="mb-3">
            <label class="form-label">Giá Bán</label>
            <input type="number" name="sale_price" class="form-control" required>
        </div>

        <!-- Mô Tả -->
        <div class="mb-3">
            <label class="form-label">Mô Tả</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <!-- Hình Ảnh -->
        <div class="mb-3">
            <label class="form-label">Hình Ảnh</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Thêm Sản Phẩm</button>
    </form>
</div>

<!-- JavaScript cho dropdown phụ thuộc -->
<script>
    // Lấy danh sách loại sản phẩm được truyền từ controller
    const types = @json($types);

    // Khi danh mục thay đổi, cập nhật dropdown Loại Sản Phẩm
    document.getElementById('category_id').addEventListener('change', function() {
        const categoryId = this.value;
        const typeSelect = document.getElementById('type_id');
        // Xóa các option cũ
        typeSelect.innerHTML = '<option value="">-- Chọn Loại Sản Phẩm --</option>';

        // Lọc các loại có category_id phù hợp và thêm vào dropdown
        types.forEach(function(type) {
            if (type.category_id == categoryId) {
                const option = document.createElement('option');
                option.value = type.id;
         
                option.text = type.name;
                typeSelect.appendChild(option);
            }
        });
    });
</script>
@endsection
