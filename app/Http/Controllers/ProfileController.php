<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Quy tắc validate
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Cập nhật thông tin cơ bản
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Xử lý avatar
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if (!empty($user->avatar) && file_exists(public_path('images/' . $user->avatar))) {
                @unlink(public_path('images/' . $user->avatar));
            }

            // Tạo tên file mới
            $avatarName = time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('images'), $avatarName);
            $user->avatar = $avatarName;
        }

        // Cập nhật mật khẩu nếu có
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Lưu thông tin vào database
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Thông tin đã được cập nhật.');
    }
}
