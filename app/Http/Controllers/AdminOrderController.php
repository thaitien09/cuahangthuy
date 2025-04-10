<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name');
    
        // Lọc theo tên khách hàng
        if ($request->has('customer_name') && !empty($request->customer_name)) {
            $query->where('users.name', 'like', '%' . $request->customer_name . '%');
        }
    
        // Lọc theo mã đơn hàng
        if ($request->has('order_id') && !empty($request->order_id)) {
            $query->where('orders.id', $request->order_id);
        }
    
        // Lọc theo trạng thái
        if ($request->has('status') && !empty($request->status)) {
            $query->where('orders.status', $request->status);
        }
    
        // Lọc theo ngày đặt hàng
        if ($request->has('order_date') && !empty($request->order_date)) {
            $query->whereDate('orders.order_date', $request->order_date);
        }
    
        // Phân trang kết quả (10 đơn hàng mỗi trang)
        $orders = $query->paginate(10);
    
        // Thống kê số lượng đơn hàng theo trạng thái
        $stats = DB::table('orders')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');
    
        return view('admin.orders.index', compact('orders', 'stats'));
    }
    

    public function show($id)
    {
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as email', 'users.phone as phone')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không tồn tại.');
        }

        $orderItems = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('order_items.*', 'products.name as product_name', 'products.image as product_image')
            ->where('order_items.order_id', $id)
            ->get();

        return view('admin.orders.show', compact('order', 'orderItems'));
    }

    public function updateStatus(Request $request)
{
    // Danh sách trạng thái hợp lệ
    $validStatuses = ['Đang xử lý', 'Đang vận chuyển', 'Giao hàng thành công', 'Đã hủy'];
    
    // Kiểm tra trạng thái có hợp lệ không
    if (!in_array($request->status, $validStatuses)) {
        return redirect()->route('admin.orders.index')->with('error', 'Trạng thái không hợp lệ.');
    }

    // Bắt đầu giao dịch cơ sở dữ liệu
    DB::beginTransaction();

    try {
        // Cập nhật trạng thái đơn hàng
        DB::table('orders')
            ->where('id', $request->order_id)
            ->update(['status' => $request->status]);

        // Nếu trạng thái là "Giao hàng thành công", giảm số lượng tồn kho
        if ($request->status === 'Giao hàng thành công') {
            // Lấy các mặt hàng trong đơn
            $orderItems = DB::table('order_items')
                ->where('order_id', $request->order_id)
                ->get();

            foreach ($orderItems as $item) {
                // Cập nhật số lượng tồn kho
                DB::table('inventory')
                    ->where('product_id', $item->product_id)
                    ->update([
                        // Sử dụng GREATEST để ngăn số lượng âm
                        'quantity' => DB::raw("GREATEST(0, quantity - {$item->quantity})"),
                        'updated_at' => now()
                    ]);
            }
        }

        // Kết thúc giao dịch
        DB::commit();

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái và kho hàng thành công.');
    } catch (\Exception $e) {
        // Hoàn tác giao dịch nếu có lỗi
        DB::rollBack();

        // Ghi log lỗi
        Log::error('Lỗi cập nhật trạng thái đơn hàng: ' . $e->getMessage());

        return redirect()->route('admin.orders.index')->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái.');
    }
}

    public function destroy($id)
    {
        $order = DB::table('orders')->where('id', $id)->first();

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không tồn tại.');
        }

        if ($order->status !== 'Đã hủy') {
            return redirect()->route('admin.orders.index')->with('error', 'Chỉ có thể xóa đơn hàng đã hủy.');
        }

        DB::table('orders')->where('id', $id)->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xóa.');
    }
}
