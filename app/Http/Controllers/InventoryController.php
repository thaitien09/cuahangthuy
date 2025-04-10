<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class InventoryController extends Controller
{
    // Hiển thị danh sách kho hàng
    public function index(Request $request)
    {
        $query = DB::table('inventory')
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->select('inventory.*', 'products.name as product_name', 'products.image as product_image');
    
        // Tìm kiếm theo tên sản phẩm
        if ($request->has('search') && !empty($request->search)) {
            $query->where('products.name', 'like', '%' . $request->search . '%');
        }
    
        // Lọc theo nhà cung cấp
        if ($request->has('supplier') && !empty($request->supplier)) {
            $query->where('inventory.supplier', $request->supplier);
        }
    
        // Lọc theo trạng thái tồn kho
        if ($request->has('stock')) {
            if ($request->stock == 'low') {
                $query->where('inventory.quantity', '>', 0)->where('inventory.quantity', '<', 10);
            } elseif ($request->stock == 'out') {
                $query->where('inventory.quantity', '<=', 0);
            } elseif ($request->stock == 'new') {
                $query->where('inventory.quantity', '>=', 10);
            }
        }
    
        $inventories = $query->paginate(10);
        $suppliers = DB::table('inventory')->select('supplier')->distinct()->get();
    
        return view('admin.inventory.index', compact('inventories', 'suppliers'));
    }
    



    // Hiển thị form nhập kho
    public function create()
    {
        $products = DB::table('products')->get();
        return view('admin.inventory.create', compact('products'));
    }

    // Lưu thông tin nhập kho
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'quantity'   => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'supplier'   => 'required|array',
            'supplier.*' => 'required|string|max:255',
        ]);
    
        $data = [];
        $now = now();
    
        foreach ($request->product_id as $key => $productId) {
            $data[] = [
                'product_id' => $productId,
                'quantity'   => $request->quantity[$key],
                'supplier'   => $request->supplier[$key],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
    
        DB::table('inventory')->insert($data);
    
        return redirect()->route('inventory.index')->with('success', 'Nhập kho thành công!');
    }

  
   
    
    

    // Hiển thị form chỉnh sửa nhập kho
    public function edit($id)
    {
        $inventory = DB::table('inventory')->where('id', $id)->first();
        $products = DB::table('products')->get();

        if (!$inventory) {
            return redirect()->route('inventory.index')->with('error', 'Kho hàng không tồn tại!');
        }

        return view('admin.inventory.edit', compact('inventory', 'products'));
    }

    // Cập nhật thông tin nhập kho
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'supplier'   => 'required|string|max:255',
        ]);

        DB::table('inventory')
            ->where('id', $id)
            ->update([
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'supplier'   => $request->supplier,
                'updated_at' => now(),
            ]);

        return redirect()->route('inventory.index')->with('success', 'Cập nhật kho hàng thành công!');
    }

    // Xóa nhập kho
    public function destroy($id)
    {
        DB::table('inventory')->where('id', $id)->delete();
        return redirect()->route('inventory.index')->with('success', 'Xóa kho hàng thành công!');
    }
}
