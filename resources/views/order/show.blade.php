@include('header')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fw-bold text-primary mb-0"><i class="fas fa-file-invoice me-2"></i>Chi Tiết Đơn Hàng</h2>
               
            </div>

            <div class="card border-0 shadow-lg rounded-3 overflow-hidden mb-4">
                <div class="card-header bg-light p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-hashtag me-2"></i>Mã đơn hàng: <span class="text-primary">{{ $order->id }}</span></h5>
                        <p class="mb-0 text-muted"><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Thông tin khách hàng & Địa chỉ giao hàng -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 bg-light rounded-3">
                                <div class="card-body p-3">
                                    <h5 class="card-title fw-bold mb-3">
                                        <i class="fas fa-user-circle me-2 text-primary"></i>Thông tin khách hàng
                                    </h5>
                                    
                                    <div class="mb-4">
                                        <div class="d-flex mb-2">
                                            <div class="text-muted" style="width: 130px;">Họ tên:</div>
                                            <div class="fw-medium">{{ $order->user_name }}</div>
                                        </div>
                                        
                                        @if(isset($order->email))
                                        <div class="d-flex mb-2">
                                            <div class="text-muted" style="width: 130px;">Email:</div>
                                            <div>{{ $order->email }}</div>
                                        </div>
                                        @endif
                                        
                                        @if(isset($order->phone))
                                        <div class="d-flex mb-2">
                                            <div class="text-muted" style="width: 130px;">Số điện thoại:</div>
                                            <div>{{ $order->phone }}</div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <h5 class="card-title fw-bold mb-3">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Địa chỉ giao hàng
                                    </h5>
                                    
                                    <div>
                                        <div class="d-flex mb-2">
                                            <div class="text-muted" style="width: 130px;">Tỉnh/Thành phố:</div>
                                            <div>{{ $order->province }}</div>
                                        </div>
                                        
                                        <div class="d-flex mb-2">
                                            <div class="text-muted" style="width: 130px;">Quận/Huyện:</div>
                                            <div>{{ $order->district }}</div>
                                        </div>
                                        
                                        <div class="d-flex mb-2">
                                            <div class="text-muted" style="width: 130px;">Phường/Xã:</div>
                                            <div>{{ $order->ward }}</div>
                                        </div>
                                        
                                        <div class="d-flex mb-2">
                                            <div class="text-muted" style="width: 130px;">Địa chỉ chi tiết:</div>
                                            <div>{{ $order->address_detail }}</div>
                                        </div>
                                        
                                        <div class="d-flex mb-2">
                                            <div class="text-muted" style="width: 130px;">Lưu ý đơn hàng:</div>
                                            <div class="fst-italic">{{ $order->order_notes ?? 'Không có lưu ý' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin đơn hàng -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 bg-light rounded-3">
                                <div class="card-body p-3">
                                    <h5 class="card-title fw-bold mb-3">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>Thông tin đơn hàng
                                    </h5>
                                    
                                    <div class="d-flex align-items-center justify-content-between mb-4 p-3 bg-white rounded-3 shadow-sm">
                                        <span class="text-muted">Tổng tiền thanh toán:</span>
                                        <span class="fs-4 fw-bold text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                                    </div>
                               
                                    <h5 class="card-title fw-bold mb-3">
    <i class="fas fa-truck me-2 text-primary"></i>Trạng thái vận chuyển
</h5>

<div class="timeline mb-4">
    <!-- Đang xử lý -->
    <div class="timeline-item {{ $order->status == 'Đang xử lý' ? 'active' : '' }}">
    <div class="timeline-point {{ $order->status == 'Đang xử lý' ? 'active' : '' }}"></div>
    <div class="d-flex justify-content-between">
        <div>
            <strong>Đang xử lý</strong>
            <p class="mb-0 small">Đơn hàng đang được xử lý</p>
        </div>
        @if($order->status == 'Đang xử lý')
        <div>
            <span class="badge bg-primary">Hiện tại</span>
        </div>
        @endif
    </div>
</div>

    
    <!-- Đang vận chuyển -->
    <div class="timeline-item {{ $order->status == 'Đang vận chuyển' ? 'active' : '' }}">
        <div class="timeline-point {{ $order->status == 'Đang vận chuyển' ? 'active' : '' }}"></div>
        <div class="d-flex justify-content-between">
            <div>
                <strong>Đang vận chuyển</strong>
                <p class="mb-0 small">Đơn hàng đang được vận chuyển</p>
            </div>
            @if($order->status == 'Đang vận chuyển')
            <div>
                <span class="badge bg-primary">Hiện tại</span>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Giao hàng thành công -->
    <div class="timeline-item {{ $order->status == 'Giao hàng thành công' ? 'active' : '' }}">
        <div class="timeline-point {{ $order->status == 'Giao hàng thành công' ? 'active' : '' }}"></div>
        <div class="d-flex justify-content-between">
            <div>
                <strong>Giao hàng thành công</strong>
                <p class="mb-0 small">Đơn hàng đã được giao thành công</p>
            </div>
            @if($order->status == 'Giao hàng thành công')
            <div>
                <span class="badge bg-success">Hiện tại</span>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Đã hủy -->
    <div class="timeline-item {{ $order->status == 'Đã hủy' ? 'active' : '' }}">
        <div class="timeline-point {{ $order->status == 'Đã hủy' ? 'active' : '' }}"></div>
        <div class="d-flex justify-content-between">
            <div>
                <strong>Đã hủy</strong>
                <p class="mb-0 small">Đơn hàng đã bị hủy</p>
            </div>
            @if($order->status == 'Đã hủy')
            <div>
                <span class="badge bg-danger">Hiện tại</span>
            </div>
            @endif
        </div>
    </div>
</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Danh sách sản phẩm -->
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-shopping-cart me-2 text-primary"></i>Danh sách sản phẩm
                        </h5>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-center" style="width: 80px">Mã SP</th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col" class="text-center" style="width: 100px">Số lượng</th>
                                        <th scope="col" class="text-end" style="width: 150px">Đơn giá</th>
                                        <th scope="col" class="text-end" style="width: 180px">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderItems as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->product_id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('images/' . ($item->product_image ?? 'default.png')) }}" 
                                                     alt="Ảnh sản phẩm" class="rounded shadow-sm me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                                <span>{{ $item->product_name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} VND</td>
                                        <td class="text-end fw-bold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                                        <td class="text-end fw-bold text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
          <!-- Giữ nguyên phần button trong footer -->
<!-- Giữ nguyên phần button trong footer -->
<div class="card-footer bg-white p-4 text-center">
    <a href="{{ route('order.index') }}" class="btn btn-outline-secondary btn-lg px-4 me-2">
        <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
    </a>

</div>



<style>
.timeline {
    position: relative;
    padding-left: 30px;
    margin-bottom: 20px;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    height: 100%;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
    color: #6c757d;
}

.timeline-point {
    position: absolute;
    left: -30px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: #fff;
    border: 2px solid #dee2e6;
    top: -2px;
}

.timeline-item.active {
    color: #212529;
    font-weight: 500;
}

.timeline-point.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
}
</style>

@include('footer')