<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    public function index()
    {
        $contacts = DB::table('contacts')->get();
        return view('admin.support.index', compact('contacts'));
    }
    public function update(Request $request)
    {
        DB::table('contacts')
            ->where('id', $request->id)
            ->update(['status' => $request->status]);
    
        return response()->json(['message' => 'Cập nhật trạng thái thành công!']);
    }

}
