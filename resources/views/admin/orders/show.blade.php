@extends('layout') <!-- Giả định layout admin của bạn là 'admin.layout' -->

@section('content')
<div class="container-fluid revenue-dashboard">
    <div class="dashboard-header">
        <h2 class="dashboard-title">Chi Tiết Hóa Đơn - Mã Đơn Hàng: #{{ $order->id }}</h2>
        <div class="period-selector">
            <button class="btn btn-primary" onclick="printInvoice()">
                <i class="fas fa-print me-2"></i> In Hóa Đơn
            </button>
        </div>
    </div>

    <!-- Nội dung hóa đơn -->
    <div id="invoice-print" class="bg-white p-4 rounded shadow">
        <!-- Header hóa đơn -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div>
            <h1 class="fw-bold text-dark mb-0">Tiến Store</h1>

            </div>
            <div class="text-end">
                <h2 class="fw-bold text-primary mb-0">HÓA ĐƠN BÁN HÀNG</h2>
                <p class="mb-0 text-danger fw-bold">Mã đơn hàng: #{{ $order->id }}</p>
                <p class="mb-0 text-muted">Ngày: {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        
        <!-- Thông tin trạng thái đơn hàng -->
        <div class="alert alert-info mb-4 d-flex justify-content-between align-items-center">
            <div>
                <strong><i class="fas fa-info-circle me-1"></i> Trạng thái đơn hàng:</strong> 
                <span class="badge {{ 
                    $order->status == 'Đang xử lý' ? 'bg-warning' : 
                    ($order->status == 'Đang vận chuyển' ? 'bg-primary' : 
                    ($order->status == 'Giao hàng thành công' ? 'bg-success' : 'bg-danger')) 
                }} ms-2">{{ $order->status }}</span>
            </div>
            <div>
                <strong>Ngày đặt hàng:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
            </div>
        </div>
        
        <!-- Thông tin khách hàng và địa chỉ -->
        <div class="row mb-4 p-3 rounded" style="background-color: var(--light-color);">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fas fa-user-circle me-2 text-primary"></i>Thông tin khách hàng</h5>
                <p class="mb-1"><i class="fas fa-user me-2 text-muted"></i><strong>Họ tên:</strong> {{ $order->user_name }}</p>
                @if(isset($order->email))
                <p class="mb-1"><i class="fas fa-envelope me-2 text-muted"></i><strong>Email:</strong> {{ $order->email }}</p>
                @endif
                @if(isset($order->phone))
                <p class="mb-1"><i class="fas fa-phone me-2 text-muted"></i><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Địa chỉ giao hàng</h5>
                <p class="mb-1"><i class="fas fa-home me-2 text-muted"></i><strong>Địa chỉ chi tiết:</strong> {{ $order->address_detail }}</p>
                <p class="mb-1"><i class="fas fa-map me-2 text-muted"></i><strong>Phường/Xã:</strong> {{ $order->ward }}</p>
                <p class="mb-1"><i class="fas fa-map me-2 text-muted"></i><strong>Quận/Huyện:</strong> {{ $order->district }}</p>
                <p class="mb-1"><i class="fas fa-map me-2 text-muted"></i><strong>Tỉnh/Thành phố:</strong> {{ $order->province }}</p>
                @if(isset($order->order_notes))
                <p class="mb-1"><i class="fas fa-sticky-note me-2 text-muted"></i><strong>Ghi chú:</strong> <span class="fst-italic">{{ $order->order_notes }}</span></p>
                @endif
            </div>
        </div>
        
        <!-- Danh sách sản phẩm -->
        <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fas fa-shopping-cart me-2 text-primary"></i>Chi tiết đơn hàng</h5>
        <table class="table table-striped table-bordered modern-table">
            <thead class="table-primary">
                <tr>
                    <th class="text-center" style="width: 50px">STT</th>
                    <th>Sản phẩm</th>
                    <th class="text-center" style="width: 100px">Số lượng</th>
                    <th class="text-end" style="width: 150px">Đơn giá</th>
                    <th class="text-end" style="width: 180px">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $index => $item)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/' . ($item->product_image ?? 'default.png')) }}" 
                                 alt="Ảnh sản phẩm" class="rounded shadow-sm me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <span class="fw-medium">{{ $item->product_name }}</span>
                                <div class="small text-muted">Mã SP: {{ $item->product_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center align-middle">{{ $item->quantity }}</td>
                    <td class="text-end align-middle">{{ number_format($item->price, 0, ',', '.') }} VND</td>
                    <td class="text-end align-middle fw-bold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Tổng tiền sản phẩm:</td>
                    <td class="text-end fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Phí vận chuyển:</td>
                    <td class="text-end fw-bold">0 VND</td>
                </tr>
                <tr class="table-light">
                    <td colspan="4" class="text-end fw-bold fs-5">TỔNG THANH TOÁN:</td>
                    <td class="text-end fw-bold text-danger fs-5">{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                </tr>
            </tfoot>
        </table>
        
        <!-- Quy định và chính sách -->
        <div class="mt-4 p-3 border rounded" style="background-color: var(--light-color);">
            <h5 class="fw-bold mb-2"><i class="fas fa-info-circle me-2 text-primary"></i>Chính sách đổi trả</h5>
            <ul class="mb-0 ps-3">
                <li>Sản phẩm được đổi trả trong vòng 7 ngày kể từ ngày nhận hàng</li>
                <li>Sản phẩm phải còn nguyên tem mác, không có dấu hiệu đã qua sử dụng</li>
                <li>Khách hàng vui lòng giữ lại hóa đơn để được hỗ trợ đổi trả khi cần thiết</li>
            </ul>
        </div>
        
        <!-- Footer hóa đơn -->
      
            
            <div class="text-center mt-3 small text-muted">
                <p class="mb-0">Cảm ơn quý khách đã mua hàng tại cửa hàng chúng tôi!</p>
                <p class="mb-0">Hóa đơn điện tử này có giá trị pháp lý tương đương hóa đơn giấy.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function printInvoice() {
        const printContent = document.getElementById('invoice-print').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = `
            <html>
                <head>
                    <title>Hóa đơn bán hàng - Mã đơn hàng: {{ $order->id }}</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
                    <style>
                        body {
                            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
                            padding: 20px;
                            color: var(--text-color);
                        }
                        :root {
                            --primary-color: #4361ee;
                            --secondary-color: #3f37c9;
                            --success-color: #4cc9f0;
                            --warning-color: #f72585;
                            --danger-color: #e63946;
                            --light-color: #f8f9fa;
                            --dark-color: #212529;
                            --text-color: #495057;
                            --text-light: #6c757d;
                            --border-color: #e9ecef;
                        }
                        table {
                            border-collapse: collapse;
                            width: 100%;
                        }
                        th, td {
                            padding: 8px;
                            border: 1px solid var(--border-color);
                        }
                        .table-primary {
                            background-color: #cfe2ff !important;
                        }
                        .table-light {
                            background-color: var(--light-color) !important;
                        }
                        .text-primary {
                            color: var(--primary-color) !important;
                        }
                        .text-danger {
                            color: var(--danger-color) !important;
                        }
                        .bg-light {
                            background-color: var(--light-color) !important;
                        }
                        .border-bottom {
                            border-bottom: 1px solid var(--border-color) !important;
                        }
                        .alert-info {
                            background-color: #cff4fc !important;
                            border-color: #b6effb !important;
                        }
                        .badge {
                            display: inline-block;
                            padding: 0.35em 0.65em;
                            font-size: 0.75em;
                            font-weight: 700;
                            line-height: 1;
                            text-align: center;
                            white-space: nowrap;
                            vertical-align: baseline;
                            border-radius: 0.25rem;
                        }
                        .bg-warning {
                            background-color: #ffc107 !important;
                        }
                        .bg-primary {
                            background-color: var(--primary-color) !important;
                            color: white !important;
                        }
                        .bg-success {
                            background-color: #198754 !important;
                            color: white !important;
                        }
                        .bg-danger {
                            background-color: var(--danger-color) !important;
                            color: white !important;
                        }
                        .table-striped tbody tr:nth-of-type(odd) {
                            background-color: rgba(0, 0, 0, 0.05);
                        }
                        @media print {
                            @page {
                                size: A4;
                                margin: 10mm;
                            }
                            .alert-info {
                                background-color: #cff4fc !important;
                                border-color: #b6effb !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .table-primary {
                                background-color: #cfe2ff !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .table-light {
                                background-color: var(--light-color) !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .bg-light {
                                background-color: var(--light-color) !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .table-striped tbody tr:nth-of-type(odd) {
                                background-color: rgba(0, 0, 0, 0.05) !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .badge {
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .bg-warning {
                                background-color: #ffc107 !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .bg-primary {
                                background-color: var(--primary-color) !important;
                                color: white !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .bg-success {
                                background-color: #198754 !important;
                                color: white !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .bg-danger {
                                background-color: var(--danger-color) !important;
                                color: white !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            img {
                                display: block !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
            </html>
        `;
        
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload(); // Tải lại trang để khôi phục trạng thái giao diện admin
    }
</script>
@endsection