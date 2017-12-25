<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function show()
    {
        return view('wechat.password');
    }

    public function reset(Request $request)
    {
        $user = User::find(Auth::id());
        $result = Hash::check($request->password, $user->password);
        if ($result) {
            if ($request->resetPassword != null &&
                $request->resetPassword == $request->resetPasswordConfirm
            ) {
                $user->password = Hash::make($request->resetPassword);
                $user->save();
                Auth::attempt(['email' => $user->email, 'password' => $request->resetPassword], true);
                return back()->with('success', '密码修改成功');
            } else {
                return back()->with('error', '重复密码和新密码不同');
            }
        } else {
            return back()->with('error', '原密码错误');
        }
    }

    public function forget()
    {
        Auth::logout();
        return redirect('/password/reset');
    }
}
