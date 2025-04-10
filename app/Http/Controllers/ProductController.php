<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('products')
            ->join('types', 'products.type_id', '=', 'types.id')
            ->join('categories', 'types.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                'types.name as type_name',
                'categories.name as category_name'
            );
    
        // Tìm kiếm theo tên
        if ($request->has('search_name') && $request->search_name != '') {
            $query->where('products.name', 'like', '%' . $request->search_name . '%');
        }
    
        // Lọc theo danh mục
        if ($request->has('category') && $request->category != '') {
            $query->where('categories.id', $request->category);
        }
    
        // Lọc theo loại
        if ($request->has('type') && $request->type != '') {
            $query->where('types.id', $request->type);
        }
    
        // Sắp xếp theo giá
        if ($request->has('price_sort') && in_array($request->price_sort, ['asc', 'desc'])) {
            $query->orderBy('products.sale_price', $request->price_sort);
        }
    
        // Lấy danh sách danh mục và loại cho dropdown
        $categories = DB::table('categories')->get();
        $types = DB::table('types')->get();
    
        // Tính tổng số
        $totalProducts = $query->count(); // Tổng số sản phẩm theo bộ lọc
        $totalCategories = DB::table('categories')->count(); // Tổng số danh mục
        $totalTypes = DB::table('types')->count(); // Tổng số loại
    
        // Phân trang
        $products = $query->paginate(10);
    
        return view('admin.products.index', compact('products', 'categories', 'types', 'totalProducts', 'totalCategories', 'totalTypes'));
    }

    
    

    public function create()
    {
        // Lấy danh sách danh mục
        $categories = DB::table('categories')->select('id', 'name')->get();
    
        // Lấy danh sách loại sản phẩm có join với danh mục
        $types = DB::table('types')
            ->join('categories', 'types.category_id', '=', 'categories.id')
            ->select('types.id', 'types.name', 'types.category_id', 'categories.name as category_name')
            ->get();
    
        return view('admin.products.create', compact('categories', 'types'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'type_id'        => 'required|exists:types,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
        ]);
    
        // Lấy category_id từ bảng types
        $category = DB::table('types')->where('id', $request->type_id)->first();
        $category_id = $category ? $category->category_id : null;
    
        if (!$category_id) {
            return back()->withErrors(['type_id' => 'Loại sản phẩm không hợp lệ.'])->withInput();
        }
    
        // Xử lý hình ảnh
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $imageName);
        }
    
        // Thêm sản phẩm vào database
        DB::table('products')->insert([
            'name'           => $request->name,
            'type_id'        => $request->type_id,
            'category_id'    => $category_id, // Thêm category_id vào
            'purchase_price' => $request->purchase_price,
            'sale_price'     => $request->sale_price,
            'description'    => $request->description,
            'image'          => $imageName,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    
        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }
   

    

    public function show($id)
    {
        // Lấy thông tin sản phẩm kèm theo tên danh mục
        $product = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->where('products.id', $id)
            ->first();
    
        if (!$product) {
            return redirect()->route('home')->with('error', 'Sản phẩm không tồn tại!');
        }
    
        // Lấy các sản phẩm liên quan
        $relatedProducts = DB::table('products')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(5)
            ->get();
    
        // Tính tổng số lượng nhập kho cho sản phẩm đó từ bảng inventory
        $stock = DB::table('inventory')
            ->where('product_id', $id)
            ->sum('quantity');
        
        // Gán số lượng tồn kho vào đối tượng sản phẩm
        $product->stock = $stock;
    
        // Lấy thông tin xuất xứ (supplier) từ bảng inventory
        $latestInventory = DB::table('inventory')
            ->where('product_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();
    
        // Gán thông tin xuất xứ và ngày nhập kho vào đối tượng sản phẩm
        $product->origin = $latestInventory ? $latestInventory->supplier : 'Việt Nam';
        $product->import_date = $latestInventory ? $latestInventory->created_at : null;
    
        // Truyền cả hai biến vào view
        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
    
    


 

   public function edit($id)
{
    $product = DB::table('products')
        ->join('types', 'products.type_id', '=', 'types.id')
        ->join('categories', 'types.category_id', '=', 'categories.id')
        ->where('products.id', $id)
        ->select('products.*', 'categories.id as category_id')
        ->first();

    if (!$product) {
        return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại!');
    }

    $categories = DB::table('categories')->select('id', 'name')->get();
    $types = DB::table('types')->select('id', 'name', 'category_id')->get();

    return view('admin.products.edit', compact('product', 'categories', 'types'));
}

    

public function update(Request $request, $id)
{
    $request->validate([
        'name'           => 'required|string|max:255',
        'type_id'        => 'required|exists:types,id',
        'purchase_price' => 'required|numeric|min:0',
        'sale_price'     => 'required|numeric|min:0',
        'description'    => 'nullable|string',
        'image'          => 'nullable|image|max:2048',
    ]);

    // Lấy thông tin sản phẩm cũ
    $product = DB::table('products')->where('id', $id)->first();
    if (!$product) {
        return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại!');
    }

    $imageName = $product->image; // Mặc định giữ nguyên ảnh cũ

    if ($request->hasFile('image')) {
        $imageFile = $request->file('image');
        $imageName = time() . '_' . $imageFile->getClientOriginalName(); // Đặt tên theo file mới

        // Xóa ảnh cũ nếu tồn tại
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        // Lưu ảnh mới với đúng tên mới
        $imageFile->move(public_path('images'), $imageName);
    }

    // Cập nhật sản phẩm
    DB::table('products')->where('id', $id)->update([
        'name'           => $request->name,
        'type_id'        => $request->type_id,
        'purchase_price' => $request->purchase_price,
        'sale_price'     => $request->sale_price,
        'description'    => $request->description,
        'image'          => $imageName, // Cập nhật tên file ảnh mới
        'updated_at'     => now(),
    ]);

    return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
}



    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại!');
        }

        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

   
    
}
