<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $services = DB::table('services')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        DB::table('services')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã được thêm thành công.');
    }

    public function edit($id)
    {
        $service = DB::table('services')->where('id', $id)->first();
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        DB::table('services')->where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã được cập nhật.');
    }

    public function destroy($id)
    {
        DB::table('services')->where('id', $id)->delete();

        return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã bị xóa.');
    }
}

