<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiến Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


</html>

    <style>
    .card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}


        .navbar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-brand img {
            margin-right: 10px; /* Khoảng cách giữa logo và chữ */
            margin-top: 4px; /* Đẩy logo xuống để căn giữa với chữ */
        }

        .navbar-nav {
            flex-grow: 1;
            justify-content: center; /* Căn giữa menu */
        }
        /* Định dạng nút "Xem chi tiết" */
        ./* Định dạng nút "Xem chi tiết" */
    


        #service {
    background: #fff;
}



/* Định dạng dropdown submenu */
.dropdown-submenu {
    position: relative;
}
.dropdown-submenu .dropdown-menu {
    position: absolute;
    top: 0;
    left: 100%;
    display: none;
    min-width: 200px;
    margin-top: -5px;
}
/* Hiển thị submenu khi hover hoặc khi có focus */
.dropdown-submenu:hover > .dropdown-menu,
.dropdown-submenu:focus-within > .dropdown-menu {
    display: block;
}
#banner {
    padding: 10px 0; /* Giảm khoảng cách trên dưới */
}

.swiper-slide {
    padding: 10px 0; /* Giảm khoảng cách bên trong slide */
}

.swiper-slide .row {
    align-items: center;
}

.swiper-slide img {
    max-width: 60%; /* Thu nhỏ kích thước ảnh */
    height: auto;
}

.swiper-slide h2 {
    font-size: 1.5rem; /* Giảm kích thước tiêu đề */
    line-height: 1.2;
}

.swiper-slide .text-primary {
    font-size: 14px; /* Giảm kích thước chữ giảm giá */
}

.swiper-slide .btn {
    padding: 6px 12px; /* Giảm padding của nút */
    font-size: 12px; /* Giảm kích thước chữ trong nút */
}

.swiper-button-prev,
.swiper-button-next {
    scale: 0.6; /* Giảm kích thước nút chuyển slide */
}

   

    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Logo và tên cửa hàng -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Tiến Store" width="50" height="50">
                Tiến Store
            </a>

            <!-- Nút toggle menu cho mobile (iOS) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}">Giới Thiệu</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown">
                            Danh mục
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($categories as $category)
                                <li>
                                    <a class="dropdown-item" href="{{ url('/home?category=' . $category->id) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.index') }}">Đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index') }}">Liên hệ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/service') }}">Dịch vụ</a>
                    </li>

                    <!-- Thêm mục "Bài viết" -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/articles') }}">Bài viết</a>
                    </li>

                    <!-- Kiểm tra đăng nhập -->
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/' . (Auth::user()->avatar ?? 'avatar.jpg')) }}" 
                                     alt="avatar" class="rounded-circle" width="30" height="30">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Chỉnh sửa hồ sơ</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Quản Lý</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a>
                        </li>
                    @endauth

                    <!-- Giỏ hàng -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                </ul>
            </div> <!-- /.navbar-collapse -->
        </div> <!-- /.container -->
    </nav>
</header>

</body>
</body>

</html>
