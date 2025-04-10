<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB; // Thêm dòng này nếu bạn muốn sử dụng DB
use Laravel\Socialite\Facades\Socialite;
class AuthController extends Controller
{
    


    public function redirectToGoogle()
{
    return Socialite::driver('google')
        ->with(['prompt' => 'select_account'])
        ->redirect();
}


// Phương thức xử lý callback từ Google
public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
        
        // Tìm user trong database hoặc tạo mới
        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'password' => Hash::make(rand(100000, 999999)), // Mật khẩu ngẫu nhiên
                'role' => 'user', // Mặc định là user
            ]
        );

        // Đăng nhập
        Auth::login($user);
        
        // Kiểm tra vai trò và chuyển hướng
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('home');
        
    } catch (\Exception $e) {
        return redirect()->route('login')->withErrors(['email' => 'Đăng nhập bằng Google thất bại. Vui lòng thử lại.']);
    }
}
    // Hiển thị trang đăng nhập
    public function showLoginForm()
    {
        return view('login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            // Kiểm tra phân quyền sau khi đăng nhập
            $user = Auth::user();
            
            // Nếu là admin, điều hướng đến trang admin
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            // Nếu là customer, điều hướng về trang chủ
            return redirect()->route('home');
        }
        
        return back()->withErrors(['email' => 'Thông tin đăng nhập không đúng']);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất người dùng
        $request->session()->invalidate(); // Hủy phiên làm việc
        $request->session()->regenerateToken(); // Tạo lại CSRF token

        return redirect('/'); // Chuyển hướng về trang chủ
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
           'phone' => 'required|string|max:20|unique:users,phone',

            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,  // Lưu số điện thoại
            'password' => Hash::make($request->password),
            'role' => 'user', // Mặc định là 'user'
            'avatar' => 'avatar.jpg', // Avatar mặc định
        ]);

        return redirect('/login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập.');
    }

    public function showRegister()
    {
        return view('register'); // Không có 'auth.' vì file nằm trực tiếp trong 'views'
    }
}
