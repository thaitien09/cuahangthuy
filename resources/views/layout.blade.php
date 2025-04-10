<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Tiến Store Admin</title>
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap & JQuery -->


    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #3a5fc7;
            --secondary-color: #1cc88a;
            --sidebar-bg: #1e2a4a;
            --sidebar-hover: #2e3c64;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            box-sizing: border-box;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background-color: #f8f9fc;
        }
        
        .wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        
        /* Sidebar styling */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: #fff;
            overflow-y: auto;
            transition: all 0.3s;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-brand {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        
        .sidebar-brand img {
            width: 35px;
            height: 35px;
            margin-right: 10px;
        }
        
        .sidebar-menu {
            padding: 15px 10px;
        }
        
        .menu-category {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 15px 8px;
            font-weight: 600;
        }
        
        .sidebar a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: var(--border-radius);
            transition: all 0.2s ease-in-out;
            font-weight: 500;
        }
        
        .sidebar a i {
            width: 24px;
            margin-right: 10px;
            font-size: 1rem;
            text-align: center;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background: var(--sidebar-hover);
            color: #fff;
            transform: translateX(3px);
        }
        
        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20px;
        }
        
        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .sidebar-footer .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            margin-right: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* Content area styling */
        .content {
            flex: 1;
            padding: 0;
            overflow-y: auto;
            background-color: #f8f9fc;
            position: relative;
        }
        
        .content-header {
            background: #fff;
            padding: 15px 30px;
            border-bottom: 1px solid #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .content-header h1 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
            color: #333;
        }
        
        .content-header .breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 0.9rem;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-actions .btn {
            border-radius: 50px;
            padding: 8px 15px;
            box-shadow: none;
        }
        
        .header-actions .search-form {
            position: relative;
        }
        
        .header-actions .search-form input {
            border-radius: 50px;
            padding-left: 40px;
            border: 1px solid #e3e6f0;
            background: #f8f9fc;
        }
        
        .header-actions .search-form i {
            position: absolute;
            left: 15px;
            top: 10px;
            color: #888;
        }
        
        .notifications {
            position: relative;
        }
        
        .notifications .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.65rem;
            padding: 3px 6px;
        }
        
        .content-body {
            padding: 30px;
        }
        
        /* Dashboard cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        
        .card-stat {
            display: flex;
            align-items: center;
            border-left: 4px solid;
        }
        
        .card-stat.primary {
            border-left-color: var(--primary-color);
        }
        
        .card-stat.success {
            border-left-color: var(--secondary-color);
        }
        
        .card-stat.warning {
            border-left-color: #f6c23e;
        }
        
        .card-stat.danger {
            border-left-color: #e74a3b;
        }
        
        .stat-icon {
            font-size: 1.8rem;
            padding: 15px;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
        }
        
        .primary .stat-icon {
            background: rgba(78, 115, 223, 0.1);
            color: var(--primary-color);
        }
        
        .success .stat-icon {
            background: rgba(28, 200, 138, 0.1);
            color: var(--secondary-color);
        }
        
        .warning .stat-icon {
            background: rgba(246, 194, 62, 0.1);
            color: #f6c23e;
        }
        
        .danger .stat-icon {
            background: rgba(231, 74, 59, 0.1);
            color: #e74a3b;
        }
        
        .stat-info h3 {
            font-weight: 700;
            margin: 0 0 5px 0;
            font-size: 1.5rem;
        }
        
        .stat-info p {
            margin: 0;
            color: #858796;
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* Table styling */
        .table-section {
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .table-section h2 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: 600;
            color: #4e73df;
        }
        
        .table {
            color: #5a5c69;
        }
        
        .table th {
            border-bottom: 2px solid #e3e6f0;
            font-weight: 600;
            color: #4e73df;
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
            padding: 15px 12px;
        }
        
        .table .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status.success {
            background: rgba(28, 200, 138, 0.1);
            color: var(--secondary-color);
        }
        
        .status.pending {
            background: rgba(246, 194, 62, 0.1);
            color: #f6c23e;
        }
        
        .status.cancelled {
            background: rgba(231, 74, 59, 0.1);
            color: #e74a3b;
        }
        
        .table .actions {
            display: flex;
            gap: 8px;
        }
        
        .btn-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            padding: 0;
        }
        
        /* Toggle sidebar button for mobile */
        .toggle-sidebar {
            display: none;
            background: none;
            border: none;
            color: #555;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 991px) {
            .sidebar {
                margin-left: -260px;
                position: fixed;
                z-index: 999;
                height: 100%;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .toggle-sidebar {
                display: block;
            }
            
            .dashboard-cards {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }
        .avatar-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.dropdown-menu {
    min-width: 200px;
    padding: 10px 0;
    margin-top: 10px;
    border: none;
    border-radius: var(--border-radius);
}

.dropdown-item {
    padding: 8px 20px;
    color: #5a5c69;
}

.dropdown-item:hover {
    background-color: rgba(78, 115, 223, 0.1);
    color: var(--primary-color);
}
.avatar-img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.avatar-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.dropdown-user-details {
    width: 100%;
    min-width: 240px;
}

.dropdown-user-details .avatar-img {
    width: 50px;
    height: 50px;
}

.dropdown-menu {
    padding: 0 0 10px 0;
}

.dropdown-menu .dropdown-item {
    padding: 8px 20px;
}
    </style>
</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand d-flex align-items-center">
            <i class="fas fa-store fa-lg me-2"></i>
            <h4>Tiến Store Admin</h4>
        </div>
        
        <div class="sidebar-menu">
            <!-- Menu dành cho Admin -->
            @if(Auth::user()->role === 'admin')
            <div class="menu-category">Quản lý hệ thống</div>
            
            <a href="{{ route('admin.dashboard') }}" class="active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('users.index') }}">
                <i class="fas fa-users"></i> Quản lý người dùng
            </a>
            @endif
            
            <!-- Menu chung cho cả Admin và Nhân viên -->
            <div class="menu-category">Quản lý sản phẩm</div>
            
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('categories.index') }}">
                <i class="fas fa-list"></i> Quản lý danh mục
            </a>
            <a href="{{ route('types.index') }}">
                <i class="fas fa-tags"></i> Quản lý loại sản phẩm
            </a>
            @endif
            
            <a href="{{ route('products.index') }}">
                <i class="fas fa-box"></i> Quản lý sản phẩm
            </a>
            
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.services.index') }}">
                <i class="fas fa-stethoscope"></i> Quản lý dịch vụ
            </a>
            @endif

            <a href="{{ route('inventory.index') }}">
                <i class="fas fa-warehouse"></i> Quản lý kho hàng
            </a>
            <a href="{{ route('admin.articles.index') }}">
        <i class="fas fa-newspaper"></i> Quản lý bài viết
    </a>
            <div class="menu-category">Quản lý bán hàng</div>
            
            <a href="{{ route('admin.orders.index') }}">
                <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
            </a>
            
            <a href="{{ route('admin.comments.index') }}">
                <i class="fas fa-comments"></i> Quản lý bình luận
            </a>
            <a href="{{ route('admin.transactions.index') }}">
    <i class="fas fa-exchange-alt"></i> Quản lý giao dịch
</a>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.reports.index') }}">
                <i class="fas fa-chart-bar"></i> Báo cáo & Thống kê
            </a>
            @endif

            <a href="{{ route('admin.support.index') }}">
                <i class="fas fa-headset"></i> Hỗ trợ & Phản hồi
            </a>
        </div>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <button class="toggle-sidebar me-3">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div>
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                           
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            </div>
            
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar-img me-2">
                        <img src="{{ asset('images/' . Auth::user()->avatar) }}" alt="Avatar">
                    </div>
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="adminDropdown">
                    <li>
                        <div class="dropdown-user-details p-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar-img me-3">
                                    <img src="{{ asset('images/' . Auth::user()->avatar) }}" alt="Avatar">
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                    <small class="d-block text-muted text-capitalize">{{ Auth::user()->role }}</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a></li>
                    <li><a class="dropdown-item" href="{{ route('home') }}"><i class="fas fa-home me-2"></i>Trở về trang chủ</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                </ul>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Toggle sidebar on mobile
        $('.toggle-sidebar').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
        
        // Close sidebar when clicking outside on mobile
        $(document).on('click', function(e) {
            if ($(window).width() < 992) {
                if (!$(e.target).closest('#sidebar').length && !$(e.target).closest('.toggle-sidebar').length) {
                    $('#sidebar').removeClass('active');
                }
            }
        });
    });
</script>
@yield('scripts') <!-- DÒNG NÀY PHẢI CÓ -->
</body>
</html>