<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách danh mục
        $categories = DB::table('categories')->get();
        
        // Lấy danh sách loại sản phẩm nếu có category_id
        $types = $request->filled('category')
            ? DB::table('types')->where('category_id', $request->category)->get()
            : collect();
        
        // Truy vấn sản phẩm với điều kiện lọc
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('types', 'products.type_id', '=', 'types.id')
            ->select('products.*', 'categories.name as category_name', 'types.name as type_name');

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('products.category_id', $request->category);
        }

        // Lọc theo loại sản phẩm nếu có
        if ($request->filled('type')) {
            $query->where('products.type_id', $request->type);
        }

        // Sắp xếp theo giá
        if ($request->has('sort_price') && in_array($request->sort_price, ['asc', 'desc'])) {
            $query->orderBy('products.sale_price', $request->sort_price);
        }

        // Phân trang
        $products = $query->paginate(12);

        return view('home', compact('products', 'categories', 'types'));
    }

    public function filter(Request $request)
    {
        $categoryId = $request->query('category_id');

        // Lọc sản phẩm theo category_id
        $products = DB::table('products')
            ->leftJoin('types', 'products.type_id', '=', 'types.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id') // Chỉ dùng products.category_id
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'products.sale_price',
                'categories.name as category_name',
                'types.name as type_name'
            )
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('products.category_id', $categoryId);
            })
            ->paginate(12); // Thêm phân trang

        return response()->json($products);
    }
}
