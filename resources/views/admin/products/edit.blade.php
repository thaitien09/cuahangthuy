@extends('layout')

@section('content')
<div class="container">
    <h2>Chỉnh Sửa Sản Phẩm</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Xóa @method('PUT') vì ta sẽ chỉ dùng POST -->


        <!-- Tên Sản Phẩm -->
        <div class="form-group">
            <label for="name">Tên Sản Phẩm</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name', $product->name) }}" required>
        </div>

        <!-- Chọn Danh Mục -->
        <div class="form-group">
            <label for="category_id">Danh Mục</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">-- Chọn Danh Mục --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Chọn Loại Sản Phẩm -->
        <div class="form-group">
            <label for="type_id">Loại Sản Phẩm</label>
            <select class="form-control" id="type_id" name="type_id" required>
                <option value="">-- Chọn Loại Sản Phẩm --</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" 
                        data-category="{{ $type->category_id }}"
                        {{ old('type_id', $product->type_id) == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Giá Mua -->
        <div class="form-group">
            <label for="purchase_price">Giá Mua</label>
            <input type="number" class="form-control" id="purchase_price" name="purchase_price" 
                   value="{{ old('purchase_price', $product->purchase_price) }}" required>
        </div>

        <!-- Giá Bán -->
        <div class="form-group">
            <label for="sale_price">Giá Bán</label>
            <input type="number" class="form-control" id="sale_price" name="sale_price" 
                   value="{{ old('sale_price', $product->sale_price) }}" required>
        </div>

        <!-- Mô Tả -->
        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" rows="4">
                {{ old('description', $product->description) }}
            </textarea>
        </div>

        <!-- Hình Ảnh -->
        <div class="form-group">
            <label for="image">Hình Ảnh</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($product->image)
                <br><img src="{{ asset('images/' . $product->image) }}" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật Sản Phẩm</button>
    </form>
</div>

<!-- JavaScript cập nhật loại sản phẩm dựa trên danh mục -->
<script>
    // Danh sách loại sản phẩm từ controller
    const types = @json($types);

    document.getElementById('category_id').addEventListener('change', function() {
        const categoryId = this.value;
        const typeSelect = document.getElementById('type_id');

        // Xóa các option cũ
        typeSelect.innerHTML = '<option value="">-- Chọn Loại Sản Phẩm --</option>';

        // Lọc và thêm loại sản phẩm theo danh mục
        types.forEach(function(type) {
            if (type.category_id == categoryId) {
                const option = document.createElement('option');
                option.value = type.id;
                option.text = type.name;
                typeSelect.appendChild(option);
            }
        });

        // Giữ giá trị đã chọn trước đó (nếu có)
        typeSelect.value = "{{ $product->type_id }}";
    });

    // Khi tải trang, cập nhật danh sách loại sản phẩm
    window.onload = function() {
        document.getElementById('category_id').dispatchEvent(new Event('change'));
    };
</script>

@endsection
