@include('header')

<div class="container mt-5">
    <h1 class="fw-bold">Danh sách đơn hàng</h1>

    @if($orders->isEmpty())
        <div class="text-center text-muted mt-5">
            <i class="bi bi-truck" style="font-size: 100px;"></i>
            <p class="mt-3 fs-5">Bạn chưa có đơn hàng nào.</p>
            <p class="text-secondary">Chiếc xe vẫn đang chờ đơn hàng đầu tiên của bạn đó! 🚚</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3" style="background-color: #ff7f50;  border: none;">
    <i class="bi bi-bag-plus"></i> Mua sắm ngay
</a>

        </div>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                        <td>{{ $order->status }}</td>
                        <td class="text-center">
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-outline-dark btn-sm shadow-sm">
                                <i class="bi bi-info-circle"></i> Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@include('footer')

@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Giao dịch thành công!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        });
    </script>
@endif
