<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showPlaceForm()
{
    $userId = Auth::id() ?? 1;

    // Lấy giỏ hàng của người dùng với thông tin sản phẩm
    $carts = DB::table('carts')
        ->join('products', 'carts.product_id', '=', 'products.id')
        ->select(
            'carts.*',
            'products.sale_price',
            'products.name',
            'products.image'
        )
        ->where('carts.user_id', $userId)
        ->get();

    return view('order.place', compact('carts'));
}

    public function placeOrder(Request $request)
    {
        $userId = Auth::id() ?? 1;

        // Lấy giỏ hàng của người dùng với thông tin sản phẩm
        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.*', 'products.sale_price')
            ->where('carts.user_id', $userId)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Lấy thông tin địa chỉ từ request
        $provinceCode   = $request->input('province');
        $districtCode   = $request->input('district');
        $wardCode       = $request->input('ward');
        $addressDetail  = $request->input('address_detail');

        // Lấy tên địa chỉ từ API
        $provinceName = $this->getProvinceName($provinceCode);
        $districtName = $this->getDistrictName($districtCode, $provinceCode);
        $wardName     = $this->getWardName($wardCode, $districtCode);

        if (is_null($provinceName) || is_null($districtName) || is_null($wardName)) {
            return redirect()->back()->with('error', 'Thông tin địa chỉ không hợp lệ.');
        }

        // Tạo đơn hàng chính
        $orderId = DB::table('orders')->insertGetId([
            'user_id'       => $userId,
            'order_date'    => now(),
            'status'        => 'Đang xử lý',
            'total_amount'  => 0, // Sẽ cập nhật lại sau khi thêm order_items
            'province'      => $provinceName,
            'district'      => $districtName,
            'ward'          => $wardName,
            'address_detail'=> $addressDetail,
            'order_notes'    => $request->input('order_notes'), // Thêm dòng này
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $totalAmount = 0;

        // Thêm từng sản phẩm vào order_items
        foreach ($carts as $cart) {
            $itemTotal = $cart->sale_price * $cart->quantity;
            $totalAmount += $itemTotal;

            DB::table('order_items')->insert([
                'order_id'  => $orderId,
                'product_id'=> $cart->product_id,
                'quantity'  => $cart->quantity,
                'price'     => $cart->sale_price,
            ]);
        }

        // Cập nhật tổng tiền vào đơn hàng
        DB::table('orders')->where('id', $orderId)->update(['total_amount' => $totalAmount]);

        // Xóa giỏ hàng của người dùng
        DB::table('carts')->where('user_id', $userId)->delete();

        return redirect()->route('order.index')
        ->with('success', 'Đơn hàng đã được đặt thành công! Mã đơn: ' . $orderId);
    
    }

    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
{
    $userId = Auth::id();
    
    $orders = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->select('orders.*', 'users.name as user_name')
        ->where('orders.user_id', $userId) // Lọc đơn hàng của người dùng hiện tại
        ->get();

    foreach ($orders as $order) {
        $order->items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'order_items.*', 
                'products.name as product_name',
                'products.image as product_image'
            )
            ->where('order_items.order_id', $order->id)
            ->get();
    }
    
    return view('order.index', compact('orders'));
}


public function show($id)
{
    $userId = Auth::id(); // Lấy ID người dùng hiện tại

    // Lấy thông tin đơn hàng kèm thông tin khách hàng, bao gồm số điện thoại
    $order = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->select(
            'orders.*',
            'users.name as user_name',
            'users.email as email',
            'users.phone as phone'
        )
        ->where('orders.id', $id)
        ->where('orders.user_id', $userId) // Chỉ cho phép xem đơn hàng của người dùng hiện tại
        ->first();

    if (!$order) {
        return redirect()->back()->with('error', 'Đơn hàng không tồn tại hoặc không thuộc về bạn.');
    }

    // Lấy danh sách sản phẩm (order items) của đơn hàng
    $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->select(
            'order_items.*',
            'products.name as product_name',
            'products.image as product_image'
        )
        ->where('order_items.order_id', $id)
        ->get();

    return view('order.show', compact('order', 'orderItems'));
}


    /**
     * Lấy tên tỉnh theo mã code
     */
    private function getProvinceName($code)
    {
        $provinces = json_decode(file_get_contents("https://provinces.open-api.vn/api/?depth=3"), true);
        foreach ($provinces as $province) {
            if ($province['code'] == $code) {
                return $province['name'];
            }
        }
        return null;
    }

    /**
     * Lấy tên quận/huyện theo mã code và mã tỉnh
     */
    private function getDistrictName($districtCode, $provinceCode)
    {
        $url = "https://provinces.open-api.vn/api/p/{$provinceCode}?depth=2";
        $response = @file_get_contents($url);
        if ($response === false) {
            return null;
        }
        $data = json_decode($response, true);
        foreach ($data['districts'] as $district) {
            if ($district['code'] == $districtCode) {
                return $district['name'];
            }
        }
        return null;
    }

    /**
     * Lấy tên phường/xã theo mã code và mã quận/huyện
     */
    private function getWardName($wardCode, $districtCode)
    {
        $url = "https://provinces.open-api.vn/api/d/{$districtCode}?depth=2";
        $response = @file_get_contents($url);
        if ($response === false) {
            return null;
        }
        $data = json_decode($response, true);
        foreach ($data['wards'] as $ward) {
            if ($ward['code'] == $wardCode) {
                return $ward['name'];
            }
        }
        return null;
    }
}
