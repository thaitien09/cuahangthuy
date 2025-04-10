<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function clearCart()
    {
        $userId = auth()->id(); // Lấy ID người dùng hiện tại
        DB::table('carts')->where('user_id', $userId)->delete(); // Xóa toàn bộ giỏ hàng của user
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được xóa.');
    }
    
    public function index()
    {
        $user_id = Auth::id();
        // Lấy giỏ hàng của người dùng hiện tại với id của bảng carts được alias là cart_id
        $carts = DB::table('carts')
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->where('carts.user_id', $user_id)
                    ->select(
                        'products.name',
                        'products.description',
                        'products.sale_price',
                        'carts.quantity',
                        'products.id',
                        'products.image',
                        'carts.id as cart_id' // alias để phân biệt id của giỏ hàng
                    )
                    ->get();

        return view('cart.index', compact('carts'));
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm vào giỏ hàng.');
        }

        $user_id = Auth::id();
        $product_id = $request->input('product_id');

        DB::table('carts')->insert([
            'user_id'    => $user_id,
            'product_id' => $product_id,
            'quantity'   => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function update(Request $request, $id)
    {
        $newQuantity = (int) $request->input('quantity');

        if ($newQuantity < 1) {
            return redirect()->back()->with('error', 'Số lượng không hợp lệ!');
        }

        $cartItem = DB::table('carts')->where('id', $id)->first();
        if (!$cartItem) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
        }

        DB::table('carts')->where('id', $id)->update(['quantity' => $newQuantity]);

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công');
    }
    public function remove($id)
    {
        $userId = Auth::id();
        $cartItem = DB::table('carts')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
        }

        DB::table('carts')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->delete();

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
}

