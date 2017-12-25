<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopArea;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with('user_infos','user_wechats', 'shops')
            ->where('register',1)
            ->paginate(Helper::page());
        return view('admin.user', ['users' => $users]);
    }

    //根据搜索的参数，来显示所有用户
    public function search($key, $value)
    {
        //根据地区，返回所有用户
        $users = $this->searchKey($key, $value)
            ->with('user_infos','user_wechats', 'shops')
            ->where('register',1)
            ->paginate(Helper::page());

        return view('admin.user', [
            'users' => $users,
            'key' => $key,
            'value' => $value
        ]);
    }

    public function searchKey($key, $value)
    {
        switch ($key) {
            case 'real_name':
                return User::whereHas('user_attrs', function ($query) use ($value) {
                    $query->where('real_name', '=', $value);
                });
                break;
            case 'level' :
            case 'exp' :
            case 'ticket':
            case 'phone':
                return User::whereHas('user_infos', function ($query) use ($key, $value) {
                    $query->where($key, '=', $value);
                });
                break;
            case 'province':
            case 'city' :
                return User::whereHas('user_addresses', function ($query) use ($key, $value) {
                    $query->where($key, '=', $value);
                });
                break;
            case 'shop_name':
                return User::whereHas('shops', function ($query) use ($value) {
                    $query->where('name', 'like', "%$value%");
                });
                break;
            case 'nickname':
                return User::whereHas('user_wechats', function ($query) use ($value) {
                    $query->where('nickname', 'like', "%$value%");
                });
                break;
            case 'area_id':
                return User::whereHas('shops', function ($query) use ($value) {
                    $query->where('area_id', '=', $value);
                });
                break;
            default :
                return User::where($key, $value);
        }
    }


    public function excel($key = null, $value = null)
    {
        //根据地区，返回店铺管理员
        Excel::create($value . '用户表' . date("Y-m-d"), function ($excel) use ($key, $value) {

            $excel->sheet('Sheetname', function ($sheet) use ($key, $value) {

                $areas = ShopArea::get(['id', 'area'])
                    ->keyBy('id')
                    ->toArray();

                if ($key == null) {
                    $users = User::with('user_wechats','user_infos','user_cigarettes', 'shops')
                        ->where('register',1)
                        ->get()
                        ->toArray();
                } else {
                    $users = $this->searchKey($key, $value)
                        ->with('user_wechats','user_infos', 'user_cigarettes', 'shops')
                        ->where('register',1)
                        ->get()
                        ->toArray();
                }

                $data = [];

                $title = [
                    '用户编号',
                    '店铺编号',
                    '微信昵称',
                    '手机号',
                    '经验',
                    '等级',
                    '礼品券',
                    '烟龄',
                    '常抽品牌',
                    '期望尝试品牌',
                    '消费价位',
                    '创建时间',
                    '更新时间',
                ];

                foreach ($users as $user) {
                    array_push($data, [
                        $user['id'],
                        $user['shop_id'],
                        $user['user_wechats']['nickname'],
                        $user['user_infos']['phone'],
                        $user['user_infos']['exp'],
                        $user['user_infos']['level'],
                        $user['user_infos']['ticket'],
                        $user['user_cigarettes']['age'],
                        $user['user_cigarettes']['brand'],
                        $user['user_cigarettes']['expect'],
                        $user['user_cigarettes']['price'],
                        $user['created_at'],
                        $user['updated_at'],
                    ]);
                }

                $sheet->appendRow($title);
                $sheet->rows($data);
            });
        })->download('xls');

    }

    //删除单个店铺
    public function remove($id)
    {
        $name = User::find($id)->name;
        User::find($id)->delete();

        return back()->with('success', $name . '删除成功');
    }

    //显示单个用户的信息
    public function profile($id)
    {
        $user = User::with('user_wechats','user_infos','user_attrs','user_addresses','user_cigarettes','shops')
            ->find($id);
        return view('admin.user-profile', ['user' => $user]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
