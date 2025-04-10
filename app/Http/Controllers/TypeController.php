<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    // Hiển thị danh sách loại sản phẩm
    public function index()
    {
        $types = DB::table('types')
            ->join('categories', 'types.category_id', '=', 'categories.id')
            ->select('types.*', 'categories.name as category_name')
            ->get();

        return view('admin.types.index', compact('types'));
    }

    // Hiển thị form thêm mới loại sản phẩm
    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('admin.types.create', compact('categories'));
    }

    // Xử lý lưu loại sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:types,name',
            'category_id' => 'required|exists:categories,id',
        ]);

        DB::table('types')->insert([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('types.index')->with('success', 'Loại sản phẩm đã được thêm!');
    }

    // Hiển thị form chỉnh sửa loại sản phẩm
    public function edit($id)
    {
        $type = DB::table('types')->where('id', $id)->first();
        $categories = DB::table('categories')->get();

        if (!$type) {
            return redirect()->route('types.index')->with('error', 'Loại sản phẩm không tồn tại!');
        }

        return view('admin.types.edit', compact('type', 'categories'));
    }

    // Xử lý cập nhật loại sản phẩm
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:types,name,' . $id,
            'category_id' => 'required|exists:categories,id',
        ]);

        DB::table('types')->where('id', $id)->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'updated_at' => now(),
        ]);

        return redirect()->route('types.index')->with('success', 'Loại sản phẩm đã được cập nhật!');
    }

    // Xóa loại sản phẩm
    public function destroy($id)
    {
        DB::table('types')->where('id', $id)->delete();
        return redirect()->route('types.index')->with('success', 'Loại sản phẩm đã được xóa!');
    }
}
