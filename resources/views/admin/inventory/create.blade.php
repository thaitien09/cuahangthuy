@extends('layout')

@section('title', 'Nhập kho mới')

@section('content')
<div class="container">
    <div class="card mt-4 shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📦 Nhập kho mới</h4>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div id="product-list">
                    <div class="product-entry row align-items-center mb-3 border-bottom pb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sản phẩm</label>
                            <select name="product_id[]" class="form-select" required>
                                <option value="">-- Chọn sản phẩm --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Số lượng</label>
                            <input type="number" name="quantity[]" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Nhà cung cấp</label>
                            <input type="text" name="supplier[]" class="form-control" required>
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-outline-danger remove-product" title="Xóa sản phẩm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="button" id="add-product" class="btn btn-outline-success">
                        <i class="fas fa-plus"></i> Thêm sản phẩm
                    </button>
                    <button type="button" id="add-all-products" class="btn btn-outline-info">
                        <i class="fas fa-list"></i> Nhập tất cả sản phẩm
                    </button>
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="fas fa-save"></i> Nhập kho
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Lưu template của 1 mục nhập ban đầu
    const productList = document.getElementById('product-list');
    const templateEntry = productList.firstElementChild.cloneNode(true);

    document.getElementById('add-product').addEventListener('click', function () {
        const newEntry = templateEntry.cloneNode(true);
        // Xoá giá trị các input
        newEntry.querySelectorAll('input').forEach(input => input.value = '');
        // Đặt lại select về giá trị mặc định
        newEntry.querySelector('select[name="product_id[]"]').selectedIndex = 0;
        productList.appendChild(newEntry);
    });

    document.getElementById('add-all-products').addEventListener('click', function () {
        // Lấy danh sách sản phẩm từ biến PHP
        const products = @json($products);
        // Xoá danh sách hiện tại (nếu muốn nhập lại toàn bộ sản phẩm)
        productList.innerHTML = '';
        products.forEach(product => {
            const newEntry = templateEntry.cloneNode(true);
            // Đặt giá trị của select theo product id
            newEntry.querySelector('select[name="product_id[]"]').value = product.id;
            // Đặt số lượng mặc định là 1 (hoặc bạn có thể thay đổi)
            newEntry.querySelector('input[name="quantity[]"]').value = 1;
            // Để trống nhà cung cấp, người dùng tự nhập
            newEntry.querySelector('input[name="supplier[]"]').value = '';
            productList.appendChild(newEntry);
        });
    });

    document.addEventListener('click', function (event) {
        if (event.target.closest('.remove-product')) {
            if (document.querySelectorAll('.product-entry').length > 1) {
                event.target.closest('.product-entry').remove();
            }
        }
    });
</script>
@endsection
