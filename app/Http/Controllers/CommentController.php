<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    // Existing store method for customer reviews
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:5',
            'product_id' => 'required|exists:products,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'content' => $request->content,
            'created_at' => now(),
        ];

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/comments', $imageName);
            $data['image'] = $imageName;
        }

        $commentId = DB::table('comments')->insertGetId($data);

        // Get user info for response
        $userName = Auth::user()->name;

        $comment = [
            'id' => $commentId,
            'user_id' => Auth::id(),
            'user_name' => $userName,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'content' => $request->content,
            'created_at' => Carbon::now()->diffForHumans(),
        ];

        if (isset($data['image'])) {
            $comment['image'] = $data['image'];
            $comment['image_url'] = asset('storage/comments/' . $data['image']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đánh giá của bạn đã được gửi thành công!',
            'comment' => $comment
        ]);
    }

    // New method for admin/staff replies
    public function reply(Request $request)
    {
        // Validate the user is admin or staff
        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này!'
            ], 403);
        }

        $request->validate([
            'content' => 'required|string|min:1',
            'parent_id' => 'required|exists:comments,id',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'product_id' => DB::table('comments')->where('id', $request->parent_id)->value('product_id'),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
            'created_at' => now(),
        ];

        $replyId = DB::table('comments')->insertGetId($data);

        // Lấy thông tin người trả lời
        $userName = Auth::user()->name;

        $reply = [
            'id' => $replyId,
            'user_id' => Auth::id(),
            'user_name' => $userName,
            'product_id' => $data['product_id'],
            'content' => $request->content,
            'parent_id' => $request->parent_id,
            'created_at' => Carbon::now()->diffForHumans(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Phản hồi của bạn đã được gửi thành công!',
            'reply' => $reply
        ]);
    }
    public function loadMore(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'last_comment_id' => 'nullable|integer',
    ]);

    $query = DB::table('comments')
        ->where('product_id', $request->product_id)
        ->orderBy('created_at', 'desc')
        ->limit(5);

    if ($request->has('last_comment_id')) {
        $query->where('id', '<', $request->last_comment_id);
    }

    $comments = $query->get();

    return response()->json([
        'success' => true,
        'comments' => $comments,
    ]);
}

}