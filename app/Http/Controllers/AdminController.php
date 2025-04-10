<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Thêm để sử dụng Hash cho mật khẩu

class AdminController extends Controller
{
    public function __construct()
    {
        // Kiểm tra ngay khi khởi tạo controller
        // Lưu ý: Cách này có thể gặp một số hạn chế nếu bạn dùng nhiều phương thức khác nhau,
        // vì auth() có thể chưa được khởi tạo sẵn lúc constructor chạy.
        // Do đó, bạn có thể chuyển kiểm tra này vào bên trong các phương thức xử lý nếu cần.
        if (!auth()->check() || (auth()->user()->role !== 'admin' && auth()->user()->role !== 'staff')) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    
   
}
