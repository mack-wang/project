<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest.admin', ['except' => 'logout']);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            if (Auth::guard('admin')->attempt(['name' => $request->name, 'password' => $request->password])) {
                return view('admin.home', ['admin'=>$request->name]);
            } else {
                Session::flash('error', '账号或密码出错');
                return redirect('admin/login')->withInput();
            }
        } else {
            return view('admin.login');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return view('admin.login');
    }


}
