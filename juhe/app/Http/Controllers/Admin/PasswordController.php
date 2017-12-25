<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function show()
    {
        return view('admin.password');
    }

    public function reset(Request $request)
    {
        $admin = Admin::find(Auth::guard('admin')->id());
        $result = Hash::check($request->password, $admin->password);
        if ($result) {
            if ($request->resetPassword != null &&
                $request->resetPassword == $request->resetPasswordConfirm
            ) {
                $admin->password = Hash::make($request->resetPassword);
                $admin->save();
                Auth::guard('admin')->attempt(['name' => $admin->name, 'password' => $request->resetPassword], true);
                return back()->with('success', '密码修改成功');
            } else {
                return back()->with('error', '重复密码和新密码不同');
            }
        } else {
            return back()->with('error', '原密码错误');
        }
    }

}
