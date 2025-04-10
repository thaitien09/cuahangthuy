@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mt-4 text-center text-primary">🚀 Hệ Thống Quản Lý Phòng Khám Thú Y</h1>

    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-body p-4">
                    <h3 class="card-title text-center">📌 Thông Tin Dự Án</h3>
                    <hr>

                    <p class="card-text">
                        <strong>🔹 Người thực hiện:</strong>
                        <span class="text-success">Thái Tiến</span>
                    </p>
                    <p class="card-text">
                        <strong>🔹 Thời gian thực hiện:</strong> 2 tháng
                    </p>
                    <p class="card-text">
                        <strong>🔹 Mô tả:</strong> 
                        Hệ thống giúp quản lý phòng khám thú y với các tính năng 
                        theo dõi khách hàng, đơn hàng, doanh thu, sản phẩm và dịch vụ thú y.
                    </p>

                    <p class="card-text"><strong>🔹 Tính năng chính:</strong></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">✔️ Quản lý khách hàng</li>
                        <li class="list-group-item">✔️ Quản lý đơn hàng</li>
                        <li class="list-group-item">✔️ Quản lý sản phẩm & dịch vụ thú y</li>
                        <li class="list-group-item">✔️ Báo cáo thống kê doanh thu</li>
                        <li class="list-group-item">✔️ Hệ thống đăng nhập & phân quyền</li>
                    </ul>

                    <p class="card-text mt-3"><strong>🔹 Công nghệ sử dụng:</strong></p>
                    <div class="d-flex flex-wrap">
                        <span class="badge bg-primary">HTML</span>
                        <span class="badge bg-success">CSS</span>
                        <span class="badge bg-danger">Laravel</span>
                        <span class="badge bg-info">Bootstrap</span>
                        <span class="badge bg-warning">MySQL</span>
                    </div>

                    <p class="card-text mt-3">
                        <strong>🔹 Liên hệ:</strong>
                        <a href="mailto:your-email@example.com" class="text-decoration-none">
                            your-email@example.com
                        </a>
                    </p>
                    <p class="card-text">
                        <strong>🔹 Website:</strong>
                        <a href="https://your-website.com" class="text-decoration-none" target="_blank">
                            https://your-website.com
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        background: #ffffff;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }
    h1 {
        font-weight: bold;
    }
    .badge {
        font-size: 14px;
        padding: 10px;
        margin: 5px;
    }
</style>
@endsection
