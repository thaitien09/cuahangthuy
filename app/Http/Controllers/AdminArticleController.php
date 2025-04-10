<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class AdminArticleController extends Controller
{
    public function index()
    {
        // Sử dụng Query Builder để lấy danh sách bài viết
        $articles = DB::table('articles')->get();  // Lấy tất cả bài viết từ bảng 'articles'

        // Trả về view và truyền dữ liệu bài viết
        return view('admin.articles.index', compact('articles'));
    }
    public function create()
{
    return view('admin.articles.create');
}
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'summary' => 'nullable|string',
        'category' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'required|in:nháp,xuất bản,lưu trữ',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $filename = null;

    if ($request->hasFile('thumbnail')) {
        $file = $request->file('thumbnail');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);  // 👉 Đường dẫn mới
    }

    DB::table('articles')->insert([
        'title' => $request->input('title'),
        'summary' => $request->input('summary'),
        'category' => $request->input('category'),
        'content' => $request->input('content'),
        'status' => $request->input('status'),
        'thumbnail' => $filename,
        'slug' => Str::slug($request->input('title')),
        'user_id' => Auth::id() ?? 1,
        'view_count' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.articles.index')->with('success', 'Tạo bài viết thành công!');
}



public function edit($id)
{
    $article = DB::table('articles')->where('id', $id)->first();

    if (!$article) {
        abort(404); // Nếu không tìm thấy, trả về 404
    }

    return view('admin.articles.edit', compact('article'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'summary' => 'nullable|string',
        'category' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'required|in:nháp,xuất bản,lưu trữ',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $article = DB::table('articles')->where('id', $id)->first();

    if (!$article) {
        abort(404);
    }

    $filename = $article->thumbnail;

    // Nếu người dùng upload ảnh mới
    if ($request->hasFile('thumbnail')) {
        $file = $request->file('thumbnail');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename); // 👈 đổi thư mục từ 'uploads/thumbnails' → 'images'
    }

    DB::table('articles')->where('id', $id)->update([
        'title' => $request->input('title'),
        'summary' => $request->input('summary'),
        'category' => $request->input('category'),
        'content' => $request->input('content'),
        'status' => $request->input('status'),
        'thumbnail' => $filename,
        'slug' => Str::slug($request->input('title')),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.articles.index')->with('success', 'Cập nhật bài viết thành công!');
}

}
