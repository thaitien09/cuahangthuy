<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        // Truyền thông tin người dùng (nếu đã đăng nhập) sang view
        $user = Auth::user();
        return view('contact', compact('user'));
    }

    public function store(Request $request)
    {
        // Chỉ xác thực các trường cần thiết từ form
        $request->validate([
           
            'message' => 'required|string',
        ]);

        // Lấy thông tin người dùng đã đăng nhập
        $user = Auth::user();

        // Sử dụng Query Builder để chèn dữ liệu vào bảng contacts
        DB::table('contacts')->insert([
            'user_id' => $user ? $user->id : null, // NULL nếu không đăng nhập
            'name' => $user ? $user->name : 'Khách vãng lai', // Lấy tên từ users hoặc mặc định
            'email' => $user ? $user->email : null, // Lấy email từ users
            'phone' => $user ? $user->phone : null, // Lấy phone từ users
        
            'message' => $request->message,
            'status' => 'Chưa xử lý',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('contact.index')->with('success', 'Tin nhắn của bạn đã được gửi thành công!');
    }
}