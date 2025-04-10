@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <!-- Header với gradient -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white shadow overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg bg-white bg-opacity-25 rounded-circle p-3 me-4">
                            <i class="fas fa-shopping-cart fa-2x text-white"></i>
                        </div>
                        <div>
                            <h1 class="fw-bold mb-0">Quản lý đơn hàng</h1>
                            <p class="mb-0 opacity-75">Quản lý và theo dõi tất cả đơn hàng của khách hàng</p>
                        </div>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 mt-n4 me-n4">
                    <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M50 0H200V200C100 200 0 100 0 0H50Z" fill="rgba(255,255,255,0.05)"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê kiểu dashboard hiện đại -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden hover-lift">
                <div class="card-body position-relative p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-md bg-info-subtle rounded-circle p-3 me-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-spinner fa-xl text-info"></i>
                        </div>
                        <span class="badge bg-info-subtle text-info">Đang xử lý</span>
                    </div>
                    <h3 class="fw-bold mb-0 display-6">{{ $stats['Đang xử lý'] ?? 0 }}</h3>
                    <p class="text-muted mb-3 small">Đơn hàng cần xử lý</p>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden hover-lift">
                <div class="card-body position-relative p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-md bg-warning-subtle rounded-circle p-3 me-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-truck fa-xl text-warning"></i>
                        </div>
                        <span class="badge bg-warning-subtle text-warning">Đang vận chuyển</span>
                    </div>
                    <h3 class="fw-bold mb-0 display-6">{{ $stats['Đang vận chuyển'] ?? 0 }}</h3>
                    <p class="text-muted mb-3 small">Đơn hàng đang giao</p>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden hover-lift">
                <div class="card-body position-relative p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-md bg-success-subtle rounded-circle p-3 me-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-check-circle fa-xl text-success"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success">Thành công</span>
                    </div>
                    <h3 class="fw-bold mb-0 display-6">{{ $stats['Giao hàng thành công'] ?? 0 }}</h3>
                    <p class="text-muted mb-3 small">Đơn hàng thành công</p>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden hover-lift">
                <div class="card-body position-relative p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-md bg-danger-subtle rounded-circle p-3 me-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-times-circle fa-xl text-danger"></i>
                        </div>
                        <span class="badge bg-danger-subtle text-danger">Đã hủy</span>
                    </div>
                    <h3 class="fw-bold mb-0 display-6">{{ $stats['Đã hủy'] ?? 0 }}</h3>
                    <p class="text-muted mb-3 small">Đơn hàng đã hủy</p>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts với thiết kế hiện đại hơn -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 d-flex align-items-center" role="alert">
            <div class="bg-success-subtle p-2 rounded-circle me-3">
                <i class="fas fa-check-circle text-success"></i>
            </div>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0 d-flex align-items-center" role="alert">
            <div class="bg-danger-subtle p-2 rounded-circle me-3">
                <i class="fas fa-exclamation-circle text-danger"></i>
            </div>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form tìm kiếm redesigned -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex align-items-center">
                <div class="icon-shape bg-primary-subtle rounded-circle p-2 me-3">
                    <i class="fas fa-search text-primary"></i>
                </div>
                <h5 class="mb-0">Tìm kiếm đơn hàng</h5>
                <button class="btn btn-sm btn-link ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse" aria-expanded="true">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
        <div class="collapse show" id="searchCollapse">
            <div class="card-body bg-light bg-opacity-50">
                <form action="{{ route('admin.orders.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" name="customer_name" class="form-control border-0 shadow-sm" id="customerName" placeholder="Nhập tên khách hàng" value="{{ request('customer_name') }}">
                                <label for="customerName">
                                    <i class="fas fa-user text-muted me-1"></i> Tên khách hàng
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="text" name="order_id" class="form-control border-0 shadow-sm" id="orderId" placeholder="Nhập mã đơn hàng" value="{{ request('order_id') }}">
                                <label for="orderId">
                                    <i class="fas fa-hashtag text-muted me-1"></i> Mã đơn hàng
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <select name="status" class="form-select border-0 shadow-sm" id="status">
                                    <option value="">Tất cả</option>
                                    <option value="Đang xử lý" {{ request('status') == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="Đang vận chuyển" {{ request('status') == 'Đang vận chuyển' ? 'selected' : '' }}>Đang vận chuyển</option>
                                    <option value="Giao hàng thành công" {{ request('status') == 'Giao hàng thành công' ? 'selected' : '' }}>Giao hàng thành công</option>
                                    <option value="Đã hủy" {{ request('status') == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                                <label for="status">
                                    <i class="fas fa-filter text-muted me-1"></i> Trạng thái
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="date" name="order_date" class="form-control border-0 shadow-sm" id="orderDate" value="{{ request('order_date') }}">
                                <label for="orderDate">
                                    <i class="fas fa-calendar-alt text-muted me-1"></i> Ngày đặt
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary shadow-sm me-2 d-flex align-items-center">
                                <i class="fas fa-search me-2"></i>Tìm kiếm
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                                <i class="fas fa-redo me-2"></i>Đặt lại
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Danh sách đơn hàng redesigned -->
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex align-items-center">
                <div class="icon-shape bg-primary-subtle rounded-circle p-2 me-3">
                    <i class="fas fa-list text-primary"></i>
                </div>
                <h5 class="mb-0">Danh sách đơn hàng</h5>
                <div class="ms-auto">
                    <span class="text-muted small me-2">Sắp xếp theo:</span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary">Mới nhất</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Tổng tiền</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($orders->isEmpty())
            <div class="text-center py-5">
                <div class="empty-state">
                    <div class="empty-state-icon bg-light rounded-circle p-4 mx-auto mb-3">
                        <i class="fas fa-box-open fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Chưa có đơn hàng nào</h5>
                    <p class="text-muted small mb-3">Các đơn hàng sẽ được hiển thị ở đây khi khách hàng đặt hàng.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary">Làm mới dữ liệu</a>
                </div>
            </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle card-table">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="ps-4">Mã đơn hàng</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($orders as $order)
                                <tr class="border-top">
                                    <td class="ps-4">
                                        <span class="badge bg-primary-subtle text-primary">#{{ $order->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs bg-light rounded-circle text-center me-2 d-flex align-items-center justify-content-center">
                                                <span class="text-muted">{{ substr($order->user_name, 0, 1) }}</span>
                                            </div>
                                            <span>{{ $order->user_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="far fa-calendar-alt text-muted me-2"></i>
                                            <span>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium text-success">{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.orders.updateStatus') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <select name="status" class="form-select form-select-sm status-select border-0 shadow-sm bg-light" onchange="this.form.submit()">
                                                <option value="Đang xử lý" {{ $order->status == 'Đang xử lý' ? 'selected' : '' }} class="text-info">
                                                    <i class="fas fa-spinner"></i> Đang xử lý
                                                </option>
                                                <option value="Đang vận chuyển" {{ $order->status == 'Đang vận chuyển' ? 'selected' : '' }} class="text-warning">
                                                    <i class="fas fa-truck"></i> Đang vận chuyển
                                                </option>
                                                <option value="Giao hàng thành công" {{ $order->status == 'Giao hàng thành công' ? 'selected' : '' }} class="text-success">
                                                    <i class="fas fa-check-circle"></i> Giao hàng thành công
                                                </option>
                                                <option value="Đã hủy" {{ $order->status == 'Đã hủy' ? 'selected' : '' }} class="text-danger">
                                                    <i class="fas fa-times-circle"></i> Đã hủy
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary rounded-circle" data-bs-toggle="tooltip" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($order->status == 'Đã hủy')
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle" data-bs-toggle="tooltip" title="Xóa đơn hàng" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?');">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="card-footer bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Hiển thị {{ $orders->count() }} trong tổng số {{ $orders->total() }} đơn hàng</span>
                <div class="pagination-container">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Các biến CSS để dễ thay đổi màu sắc */
    :root {
        --primary-color: #4361ee;
        --primary-hover: #3a56d4;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --info-color: #3498db;
    }
    
    /* Background gradients */
    .bg-gradient-primary {
        background: linear-gradient(45deg, var(--primary-color), #4895ef);
    }
    
    /* Card và Hover Effects */
    .card {
        transition: all 0.3s ease;
        border-radius: 0.75rem;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
    }
    
    /* Custom Icons và Shapes */
    .avatar-xs {
        width: 32px;
        height: 32px;
    }
    
    .avatar-md {
        width: 48px;
        height: 48px;
    }
    
    .avatar-lg {
        width: 64px;
        height: 64px;
    }
    
    .icon-shape {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Subtle Background Colors */
    .bg-primary-subtle {
        background-color: rgba(67, 97, 238, 0.1);
    }
    
    .bg-info-subtle {
        background-color: rgba(52, 152, 219, 0.1);
    }
    
    .bg-warning-subtle {
        background-color: rgba(243, 156, 18, 0.1);
    }
    
    .bg-success-subtle {
        background-color: rgba(46, 204, 113, 0.1);
    }
    
    .bg-danger-subtle {
        background-color: rgba(231, 76, 60, 0.1);
    }
    
    /* Status Select */
    .status-select {
        min-width: 160px;
        transition: all 0.2s ease;
    }
    
    .status-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }
    
    /* Empty State */
    .empty-state {
        max-width: 400px;
        margin: 0 auto;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Pagination customization */
    .pagination-container .pagination .page-item .page-link {
        border-radius: 8px;
        margin: 0 2px;
        border: none;
    }
    
    .pagination-container .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        color: white;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Thêm hiệu ứng hover cho các hàng trong bảng
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(243, 244, 246, 0.4)';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
    
    // Tự động ẩn thông báo sau 5 giây
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Animation khi load trang
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
    });
});
</script>
@endsection