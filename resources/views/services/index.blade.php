@include('header')  <!-- Bao gồm header -->

<div class="container py-5">
    <!-- Page Header Section -->
    <div class="bg-white text-dark p-5 mb-5 rounded-4 shadow d-flex flex-lg-row flex-column align-items-center justify-content-between">
        <!-- Nội dung bên trái -->
        <div class="text-center text-lg-start d-flex align-items-center">
            <img src="https://cdn-icons-png.flaticon.com/512/4290/4290854.png" alt="Services Icon" style="width: 40px; height: 40px;" class="me-3">
            <div>
                <h1 class="fw-bold mb-2 fs-3">
                    Danh sách Dịch Vụ
                </h1>
                <p class="mb-0 text-muted fs-5">Chọn và mua dịch vụ phù hợp với nhu cầu của bạn</p>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="alert alert-success rounded-lg shadow-sm border-0 d-flex align-items-center mb-4">
            <i class="fas fa-check-circle me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-lg shadow-sm border-0 d-flex align-items-center mb-4">
            <i class="fas fa-exclamation-circle me-2 fs-4"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="row">
        <!-- Service Selection Section -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm rounded-lg h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-list-alt me-2"></i>Chọn Dịch Vụ</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('services.purchase', ':id') }}" id="purchaseForm">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="service" class="form-label fw-medium">Dịch vụ bạn muốn mua</label>
                            <select class="form-select form-select-lg shadow-sm" id="service" name="service_id" required onchange="updateFormAction()">
                                <option value="">-- Chọn dịch vụ --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-name="{{ $service->name }}">
                                        {{ $service->name }} - {{ number_format($service->price, 0, ',', '.') }} VNĐ
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary btn-lg fw-medium" id="selectServiceBtn" disabled onclick="showBankTransfer()">
                                <i class="fas fa-check-circle me-2"></i>Chọn Dịch Vụ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bank Transfer Section -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-lg h-100" id="bankTransferForm" style="display:none;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-credit-card me-2"></i>Thanh Toán Chuyển Khoản</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold text-dark mb-3">Thông tin tài khoản</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2 d-flex">
                                            <span class="fw-medium text-muted me-2 w-50">Ngân hàng:</span>
                                            <span class="fw-semibold">VIB</span>
                                        </li>
                                        <li class="mb-2 d-flex">
                                            <span class="fw-medium text-muted me-2 w-50">Số tài khoản:</span>
                                            <span class="fw-semibold">913263053</span>
                                        </li>
                                        <li class="d-flex">
                                            <span class="fw-medium text-muted me-2 w-50">Chủ tài khoản:</span>
                                            <span class="fw-semibold">Duong Thai Tien</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold text-dark mb-3">Quét mã QR để thanh toán</h6>
                                    <img src="qr.jpg" alt="QR Code" class="img-fluid rounded shadow-sm" style="max-width: 150px;" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">Mã giao dịch</h6>
                            <div class="d-flex align-items-center">
                                @if(isset($purchase) && $purchase)
                                    <div class="input-group">
                                        <input type="text" id="transaction-code" class="form-control bg-white" value="{{ $purchase->transaction_code }}" readonly>
                                        <button class="btn btn-primary" type="button" onclick="copyTransactionCode()">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="alert alert-primary mb-0 w-100">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span id="transaction-code">Mã giao dịch sẽ được tạo sau khi bạn chọn dịch vụ</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning d-flex">
                        <div class="me-3 fs-4">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">Hướng dẫn chuyển khoản</h6>
                            <ol class="mb-0 ps-3">
                                <li>Mở ứng dụng ngân hàng của bạn</li>
                                <li>Chọn chức năng "Chuyển khoản"</li>
                                <li>Nhập số tài khoản: <strong>913263053</strong></li>
                                <li>Nhập nội dung chuyển khoản là <strong>mã giao dịch</strong> được hiển thị ở trên</li>
                            </ol>
                        </div>
                    </div>

                    <div class="alert alert-success d-flex mb-4">
                        <div class="me-3 fs-4">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">Thông báo quan trọng</h6>
                            <p class="mb-0">Sau khi hoàn tất chuyển khoản, đơn dịch vụ của bạn sẽ được xử lý trong vòng 5-10 phút. Nếu có vấn đề, vui lòng liên hệ với chúng tôi ngay để được hỗ trợ kịp thời.</p>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg fw-medium" form="purchaseForm">
                            <i class="fas fa-check-circle me-2"></i>Xác Nhận Đã Chuyển Khoản
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History Section - Thêm margin top để tạo khoảng cách -->
    <div class="card border-0 shadow-sm rounded-lg mt-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Lịch Sử Giao Dịch</h5>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="refreshTransactionHistory()">
                    <i class="fas fa-sync-alt me-1"></i>Làm mới
                </button>
                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sort-amount-down me-2"></i>Mới nhất</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sort-amount-up me-2"></i>Cũ nhất</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-filter me-2"></i>Chỉ giao dịch thành công</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-0">
            @if(isset($purchases) && count($purchases) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Dịch Vụ</th>
                                <th>Số Tiền</th>
                                <th>Mã Giao Dịch</th>
                                <th>Trạng Thái</th>
                                <th>Ngày Tạo</th>
                                <th class="text-end pe-4">Tùy Chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $purchase->id }}</td>
                                    <td>
                                        @foreach($services as $service)
                                            @if($service->id == $purchase->service_id)
                                                {{ $service->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($purchase->amount, 0, ',', '.') }} VNĐ</td>
                                    <td><span class="badge bg-light text-dark">{{ $purchase->transaction_code }}</span></td>
                                    <td>
                                        @if($purchase->status == 'Hoàn tất')
                                            <span class="badge bg-success">Hoàn tất</span>
                                        @elseif($purchase->status == 'Đang xử lý')
                                            <span class="badge bg-warning text-dark">Đang xử lý</span>
                                        @else
                                            <span class="badge bg-danger">{{ $purchase->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y H:i', strtotime($purchase->created_at)) }}</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-history fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Chưa có giao dịch nào</h5>
                    <p class="text-muted">Các giao dịch của bạn sẽ xuất hiện ở đây</p>
                </div>
            @endif
        </div>
    </div>
</div>

@include('footer')  <!-- Bao gồm footer -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
    function updateFormAction() {
        const serviceSelect = document.getElementById('service');
        const selectServiceBtn = document.getElementById('selectServiceBtn');
        
        if (serviceSelect.value) {
            selectServiceBtn.disabled = false;
            
            // Update form action
            const serviceId = serviceSelect.value;
            const formAction = '{{ route('services.purchase', ':id') }}';
            document.getElementById('purchaseForm').action = formAction.replace(':id', serviceId);
        } else {
            selectServiceBtn.disabled = true;
        }
    }
    
    function showBankTransfer() {
        const bankTransferForm = document.getElementById('bankTransferForm');
        bankTransferForm.style.display = 'block';
        
        // Scroll to bank transfer section with additional offset
        bankTransferForm.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function copyTransactionCode() {
        const codeElement = document.getElementById('transaction-code');
        navigator.clipboard.writeText(codeElement.innerText || codeElement.value);
        
        // Show toast notification
        const toastContainer = document.createElement('div');
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        
        toastContainer.innerHTML = `
            <div class="toast show align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        Đã sao chép mã giao dịch thành công!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        document.body.appendChild(toastContainer);
        
        setTimeout(() => {
            toastContainer.remove();
        }, 3000);
    }
    
    function refreshTransactionHistory() {
        // Show loading spinner
        const transactionTable = document.querySelector('.table-responsive');
        transactionTable.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Đang tải...</span>
                </div>
                <p class="mt-2">Đang làm mới dữ liệu...</p>
            </div>
        `;
        
        // Reload the page after 1 second
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }
</script>