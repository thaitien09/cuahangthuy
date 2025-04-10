<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ArticleController extends Controller
{
    public function index()
    {
        // Sử dụng Query Builder để lấy các bài viết với trạng thái 'xuất bản'
        $articles = DB::table('articles')
            ->where('status', 'xuất bản') // Lọc bài viết có trạng thái 'xuất bản'
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo giảm dần
            ->get(); // Lấy tất cả các bài viết

        // Trả về view với các bài viết
        return view('articles.index', compact('articles'));
    }

    public function show($slug) {
        // Lấy bài viết cụ thể theo slug bằng Query Builder
        $article = DB::table('articles')->where('slug', $slug)->first();
        
        // Kiểm tra nếu bài viết không tồn tại
        if (!$article) {
            return redirect()->route('articles.index')->with('error', 'Bài viết không tồn tại!');
        }
        
        // Xử lý tăng lượt xem
        $viewIncremented = false;
        
        // Kiểm tra nếu người dùng đã đăng nhập
        if (auth()->check()) {
            $userId = auth()->id();
            
            // Lấy thông tin người dùng
            $user = DB::table('users')->where('id', $userId)->first();
            
            // Lấy danh sách bài viết đã xem từ cột JSON
            $viewedArticles = json_decode($user->viewed_articles ?? '[]', true);
            
            // Kiểm tra xem bài viết hiện tại đã có trong danh sách chưa
            if (!in_array($article->id, $viewedArticles)) {
                // Tăng lượt xem bài viết
                DB::table('articles')
                    ->where('id', $article->id)
                    ->update(['view_count' => DB::raw('view_count + 1')]);
                    
                // Thêm ID bài viết vào danh sách đã xem
                $viewedArticles[] = $article->id;
                
                // Cập nhật thông tin vào database
                DB::table('users')
                    ->where('id', $userId)
                    ->update(['viewed_articles' => json_encode($viewedArticles)]);
                    
                $viewIncremented = true;
            }
        } else {
            // Đối với người dùng chưa đăng nhập, sử dụng session để tránh đếm trùng
            $sessionKey = 'viewed_article_' . $article->id;
            
            if (!session()->has($sessionKey)) {
                // Tăng lượt xem
                DB::table('articles')
                    ->where('id', $article->id)
                    ->update(['view_count' => DB::raw('view_count + 1')]);
                    
                session()->put($sessionKey, true);
                $viewIncremented = true;
            }
        }
        
        // Lấy lại bài viết sau khi có thể đã cập nhật lượt xem
        if ($viewIncremented) {
            $article = DB::table('articles')->where('slug', $slug)->first();
        }
        
        // Lấy tất cả bài viết bằng Query Builder
        $articles = DB::table('articles')->get();
        
        // Pass danh sách bài viết và bài viết cụ thể vào view
        return view('articles.show', compact('articles', 'article'));
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
