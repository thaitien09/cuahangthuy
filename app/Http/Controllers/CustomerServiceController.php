<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    // Hiển thị danh sách dịch vụ
    public function index()
    {
        // Lấy danh sách dịch vụ từ bảng services
        $services = DB::table('services')->get();
        
        // Lấy lịch sử giao dịch của người dùng đã đăng nhập
        $purchases = DB::table('service_purchases')
            ->where('user_id', auth()->id()) // Lọc theo user_id của người dùng hiện tại
            ->get(); // Lấy tất cả giao dịch của người dùng
    
        // Giả sử bạn muốn lấy giao dịch gần nhất của người dùng đã đăng nhập
        $purchase = DB::table('service_purchases')
            ->where('user_id', auth()->id()) // Lọc theo user_id của người dùng hiện tại
            ->where('status', 'Chờ xử lý') // Lọc theo trạng thái của giao dịch
            ->first(); // Lấy giao dịch đầu tiên nếu có
        
        // Trả về view với dữ liệu purchase, services và purchases (lịch sử giao dịch)
        return view('services.index', compact('purchase', 'services', 'purchases'));
    }
    

    // Xử lý mua dịch vụ
    public function purchase(Request $request, $id)
    {
        // Truy vấn dịch vụ từ cơ sở dữ liệu
        $service = DB::table('services')->where('id', $id)->first();

        // Kiểm tra nếu dịch vụ không tồn tại
        if (!$service) {
            return redirect()->back()->with('error', 'Dịch vụ không tồn tại.');
        }

        // Lấy giá dịch vụ từ cơ sở dữ liệu (giá cố định cho mỗi dịch vụ)
        $amount = $service->price; // Giả sử trong bảng services có cột 'price'

        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        // Thực hiện thao tác chèn dữ liệu vào bảng service_purchases
        DB::table('service_purchases')->insert([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'amount' => $amount,  // Sử dụng giá của dịch vụ
            'transaction_code' => 'TXN-' . Str::random(10),
            'status' => 'Chờ xử lý', // Giá trị hợp lệ
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trả về trang danh sách dịch vụ với thông báo thành công
        return redirect()->route('services.index')->with('success', 'Mua dịch vụ thành công!');
    }

    // Hiển thị lịch sử giao dịch của người dùng
    public function transactionHistory()
    {
        // Lấy tất cả giao dịch của người dùng hiện tại từ bảng service_purchases
        $purchases = DB::table('service_purchases')
            ->where('user_id', auth()->id())  // Lọc theo user_id
            ->get();  // Lấy tất cả giao dịch của người dùng

        // Trả về view với danh sách giao dịch
        return view('services.history', compact('purchases'));
    }

    // Hiển thị form thanh toán cho dịch vụ
    public function showPaymentForm($serviceId)
    {
        // Lấy thông tin giao dịch từ bảng service_purchases
        $purchase = DB::table('service_purchases')
            ->where('service_id', $serviceId)
            ->where('user_id', auth()->id())  // Kiểm tra người dùng hiện tại
            ->where('status', 'Chờ xử lý')  // Chỉ lấy các giao dịch chưa hoàn thành
            ->first();

        if (!$purchase) {
            return redirect()->back()->with('error', 'Không tìm thấy giao dịch này!');
        }

        // Trả về view với mã giao dịch
        return view('payment_form', compact('purchase'));
    }
}
