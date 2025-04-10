@include('header')
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập | Tiến Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS chỉ dành cho form đăng nhập */
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .login-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .login-container .form-group {
            margin-bottom: 15px;
        }
        
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #ff7f50 !important;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .login-container button:hover {
            background-color: #ff6b3d !important;
        }
        
        .login-container a {
            text-decoration: none;
            color: #007bff;
        }
        
        .login-container a:hover {
            text-decoration: underline;
        }
        
        /* CSS cho phần đăng nhập bằng mạng xã hội */
        .social-login {
            margin-top: 20px;
            text-align: center;
        }

        .social-login p {
            margin-bottom: 10px;
            position: relative;
        }

        .social-login p:after {
            content: "";
            display: block;
            height: 1px;
            width: 100%;
            background-color: #e0e0e0;
            position: absolute;
            top: 50%;
            z-index: 1;
        }

        .social-login p span {
            display: inline-block;
            background-color: #fff;
            padding: 0 10px;
            position: relative;
            z-index: 2;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Nhập email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember"> Duy trì đăng nhập
                </label>
            </div>
            <button type="submit">Đăng nhập</button>
            <div class="form-group text-center mt-2">
                <a href="#">Quên mật khẩu?</a> | <a href="/register">Đăng ký</a>
            </div>
        </form>
        
        <!-- Phần đăng nhập bằng mạng xã hội -->
        <div class="social-login">
    <p><span>Hoặc đăng nhập với</span></p>
    <div class="social-icons">
        <a href="" class="social-icon facebook" style="text-decoration: none;">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="{{ route('auth.google') }}" class="social-icon google" style="text-decoration: none;">
            <i class="fab fa-google"></i>
        </a>
        <a href="" class="social-icon twitter" style="text-decoration: none;">
            <i class="fab fa-twitter"></i>
        </a>
    </div>
</div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Thêm hiệu ứng hover cho các icon
        document.querySelectorAll('.social-icons a').forEach(icon => {
            icon.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 5px 10px rgba(0,0,0,0.2)';
            });
            
            icon.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
            });
        });
    </script>
</body>
</html>
@include('footer')