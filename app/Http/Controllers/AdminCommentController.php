<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCommentController extends Controller
{
    public function index()
{
    $comments = DB::table('comments')
    ->leftJoin('users', 'comments.user_id', '=', 'users.id')
    ->leftJoin('products', 'comments.product_id', '=', 'products.id')
    ->select('comments.*', 'users.name as user_name', 'users.role as user_role', 'products.name as product_name')
    ->orderBy('comments.created_at', 'desc')
    ->get();



    return view('admin.comments.index', compact('comments'));
}


    public function destroy($id)
    {
        DB::table('comments')->where('id', $id)->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Xóa bình luận thành công!');
    }
   
}
