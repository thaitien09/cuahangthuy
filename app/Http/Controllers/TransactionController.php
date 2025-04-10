<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $servicePurchases = DB::table('service_purchases')->get();

        return view('admin.transactions.index', compact('servicePurchases'));
    }
    public function updateStatus(Request $request, $id)
{
    DB::table('service_purchases')
        ->where('id', $id)
        ->update(['status' => $request->status]);

    return redirect()->route('admin.transactions.index')->with('success', 'Cập nhật trạng thái thành công!');
}
public function show($id)
{
    $transaction = DB::table('service_purchases')->where('id', $id)->first();

    if (!$transaction) {
        return redirect()->route('admin.transactions.index')->with('error', 'Giao dịch không tồn tại!');
    }

    // Lấy thông tin người dùng
    $user = DB::table('users')->where('id', $transaction->user_id)->first();

    // Lấy thông tin dịch vụ
    $service = DB::table('services')->where('id', $transaction->service_id)->first();

    return view('admin.transactions.show', compact('transaction', 'user', 'service'));
}
}
