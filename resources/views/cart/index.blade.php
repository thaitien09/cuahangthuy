@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Đã thêm vào giỏ!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500, // ⏱ chỉ hiện 1.5 giây
                timerProgressBar: true
            });
        });
    </script>
@endif



@include('header')

<div class="container mt-5">
    <h1 class="fw-bold text-center mb-4">Giỏ hàng</h1>
    <div class="row">
        @if($carts->isEmpty())
            <div class="col-12 text-center">
                <img src="{{ asset('images/giohangtrong.png') }}" alt="Giỏ hàng trống" class="img-fluid" style="width: 200px;">
                <p class="text-muted mt-3">Giỏ hàng của bạn đang trống.</p>
                <a href="{{ url('/') }}" class="btn btn-dark">Mua sắm ngay</a>
            </div>
        @else
            <div class="col-12">
                @foreach($carts as $cart)
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="row g-0 align-items-center">
                            <!-- Ảnh sản phẩm -->
                            <div class="col-auto text-center p-3">
                                <img 
                                    src="{{ asset('images/'.$cart->image) }}" 
                                    alt="{{ $cart->name }}" 
                                    class="img-fluid rounded" 
                                    style="max-width: 120px;"
                                >
                            </div>

                            <!-- Thông tin sản phẩm -->
                            <div class="col px-3 py-2">
                                <div class="card-body p-0">
                                    <h5 class="card-title fw-bold mb-1">
                                        {{ $cart->name }}
                                    </h5>
                                    <!-- Giá sản phẩm -->
                                    <p class="text-danger fw-bold mb-2">
                                        {{ number_format($cart->sale_price, 0, ',', '.') }} VND
                                    </p>
                                    <!-- Wishlist -->
                                    <p class="small mb-2">
                                        <a href="#" class="text-decoration-none text-muted">
                                            ♡ Thêm vào Wishlist
                                        </a>
                                    </p>

                                    <!-- Form cập nhật số lượng -->
                                    <form 
                                        action="{{ route('cart.update', $cart->cart_id) }}" 
                                        method="GET" 
                                        class="d-flex align-items-center"
                                    >
                                        <input 
                                            type="number" 
                                            name="quantity" 
                                            value="{{ $cart->quantity }}" 
                                            min="1" 
                                            class="form-control text-center me-2" 
                                            style="width: 60px;"
                                        >
                                        <button type="submit" class="btn btn-dark btn-sm">
                                            Cập nhật
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Nút xóa -->
                            <div class="col-auto text-center">
                                <form action="{{ route('cart.remove', $cart->cart_id) }}" method="POST" class="p-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-secondary" style="font-size: 1.2rem;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Thanh điều hướng ở dưới -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                    <div class="mb-3 mb-md-0">
                        <a href="{{ url('/') }}" class="btn btn-outline-dark">
                            ← TIẾP TỤC MUA HÀNG
                        </a>
                    </div>
                    <div class="text-md-end">
                        <h5 class="mb-2">
                            Tổng tiền: 
                            <span class="fw-bold text-danger">
                                {{ number_format($carts->sum(fn($cart) => $cart->sale_price * $cart->quantity), 0, ',', '.') }} VND
                            </span>
                        </h5>
                        <div>
                            <a href="{{ route('order.place') }}" class="btn btn-dark me-2">ĐẶT HÀNG</a>
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    XÓA GIỎ HÀNG
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@include('footer')
