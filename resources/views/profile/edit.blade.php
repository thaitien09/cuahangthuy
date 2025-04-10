@include('header')

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .profile-container {
            display: flex;
            justify-content: center; /* Căn giữa */
        }

        .profile-card {
            width: 250px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-right: 20px;
        }

        .avatar-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .avatar-wrapper img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        .update-card {
            width: 50%;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-pink {
            background-color: #FF5C5C;
            color: white;
            border: none;
        }

        .btn-pink:hover {
            background-color: #e54c4c;
            color: white;
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Thông tin cá nhân</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-container">
        <div class="profile-card">
            <div class="avatar-wrapper">
                <img src="{{ asset('images/' . ($user->avatar ?? 'default-avatar.jpg')) }}" alt="Avatar">
            </div>
            <h3 class="mt-3">{{ $user->name }}</h3>
            <p>{{ $user->email }}</p>
            <p>Số điện thoại: {{ $user->phone ?? 'Chưa cập nhật' }}</p> <!-- Hiển thị số điện thoại -->
        </div>

        <div class="update-card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Tên</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label> <!-- Trường nhập số điện thoại -->
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu mới (nếu muốn thay đổi)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="form-group">
                    <label for="avatar">Chọn ảnh đại diện</label>
                    <input type="file" name="avatar" class="form-control">
                </div>

                <button type="submit" class="btn btn-pink w-100">Cập nhật</button>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

@include('footer')
