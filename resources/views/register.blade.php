<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký | Tiến Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .register-container {
            max-width: 450px;
            margin: 40px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .register-header {
            background-color: white
            color: black;
            padding: 20px;
            text-align: center;
        }
        
        .register-body {
            padding: 25px;
        }
        
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .input-group-text {
            background-color: #ff7f50;
            color: white;
            border: none;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 127, 80, 0.25);
            border-color: #ff7f50;
        }
        
        .btn-register {
    background-color: #ff7f50 !important;
    border: none !important;
    width: 100%;
    padding: 10px;
    font-weight: 500;
    color: white !important;
}

        
        .btn-register:hover {
            background-color: #ff6b3d;
            color: white;
        }
        
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @include('header')
    
    <div class="container">
        <div class="register-container">
            <div class="register-header">
                <h2 class="h4 mb-0">Đăng Ký Tài Khoản</h2>
            </div>
            <div class="register-body">
                <form action="/register" method="POST">
                    @csrf
                    
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Họ và Tên" required>
                            <label for="name">Họ và Tên</label>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            <label for="email">Email</label>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </span>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" required>
                            <label for="phone">Số điện thoại</label>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                            <label for="password">Mật khẩu</label>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                            <label for="password_confirmation">Nhập lại mật khẩu</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-register">Đăng Ký Ngay</button>
                    
                    <div class="login-link">
                        <a href="/login">Đã có tài khoản? Đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @include('footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>