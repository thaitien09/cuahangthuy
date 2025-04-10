<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index(Request $request)
    {
        // Lọc người dùng theo quyền (nếu có)
        $query = User::query();
    
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
    
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
       
    
        // Lấy danh sách người dùng với phân trang
        $users = $query->paginate(10);
    
        // Tính tổng số nhân viên và khách hàng
        $totalStaff = User::where('role', 'staff')->count();
        $totalCustomers = User::where('role', 'user')->count();
    
        return view('admin.users.index', compact('users', 'totalStaff', 'totalCustomers'));
    }

    // Hiển thị form tạo người dùng mới
    public function create()
    {
        return view('admin.users.create');  // Trả về view tạo người dùng mới
    }

    // Lưu người dùng mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user,staff',
            'phone' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,phone',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 2 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'role.required' => 'Quyền không được để trống',
            'role.in' => 'Quyền không hợp lệ',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.regex' => 'Số điện thoại phải chứa 10-15 chữ số',
            'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống',
            'avatar.image' => 'File phải là hình ảnh',
            'avatar.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'avatar.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
        ]);
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
    
        if ($request->hasFile('avatar')) {
            $fileName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images'), $fileName);
            $user->avatar = $fileName;
        }
    
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'Người dùng đã được tạo thành công.');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id);  // Tìm người dùng theo ID
        return view('admin.users.edit', compact('user'));  // Trả về view chỉnh sửa người dùng
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user,staff',
            'phone' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,phone,' . $id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        
        // Kiểm tra nếu có mật khẩu mới
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }
        
        $messages = [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 2 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'role.required' => 'Quyền không được để trống',
            'role.in' => 'Quyền không hợp lệ',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.regex' => 'Số điện thoại phải chứa 10-15 chữ số',
            'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'avatar.image' => 'File phải là hình ảnh',
            'avatar.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'avatar.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
        ];
        
        $request->validate($rules, $messages);
    
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone = $request->phone;
    
        // Nếu có nhập mật khẩu mới
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar && file_exists(public_path('images/' . $user->avatar))) {
                unlink(public_path('images/' . $user->avatar));
            }
    
            $fileName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('images'), $fileName);
            $user->avatar = $fileName;
        }
    
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật thành công.');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Xóa ảnh cũ nếu có
        if ($user->avatar && file_exists(public_path('images/' . $user->avatar))) {
            unlink(public_path('images/' . $user->avatar));  // Xóa ảnh cũ
        }

        $user->delete();  // Xóa người dùng khỏi cơ sở dữ liệu

        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa thành công.');
    }
}