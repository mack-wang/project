<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('user_addresses', 'user_companies', 'user_avatars')->paginate(8);
        return view('admin.user', [
            'users' => $users,
        ]);
    }

    //根据搜索的参数，来显示所有用户
    public function search(Request $request)
    {
        //根据地区，返回所有用户
        $users = $this->searchKey($request->search, $request->value)
            ->with('user_addresses', 'user_companies', 'user_avatars')
            ->paginate(8);

        return view('admin.user', [
            'users' => $users,
        ]);
    }

    public function searchKey($key, $value)
    {
        switch ($key) {
            case 'real_name':
            case 'mail_phone':
                return User::whereHas('user_addresses', function ($query) use ($key,$value) {
                    $query->where($key, '=', $value);
                });
                break;
            case 'company':
                return User::whereHas('user_companies', function ($query) use ($value) {
                    $query->where('company', 'like', "%$value%");
                });
                break;
            default :
                return User::where($key, $value);
        }
    }
}
