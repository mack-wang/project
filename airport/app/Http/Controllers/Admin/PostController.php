<?php

namespace App\Http\Controllers\Admin;

use App\Models\PostPrize;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $users = PostPrize::with('user_infos', 'user_wechats', 'users', 'user_addresses', 'user_attrs','qrcode_prizes')
            ->paginate(Helper::page());
        return view('admin.post', ['users' => $users]);
    }

    //根据搜索的参数，来显示所有用户
    public function search($key, $value)
    {
        //根据地区，返回所有用户
        $users = $this->searchKey($key, $value)
            ->with('user_infos', 'user_wechats', 'users', 'user_addresses', 'user_attrs','qrcode_prizes')
            ->paginate(Helper::page());

        return view('admin.post', [
            'users' => $users,
            'key' => $key,
            'value' => $value
        ]);
    }

    public function searchKey($key, $value)
    {
        switch ($key) {
            case 'real_name':
                return PostPrize::whereHas('user_attrs', function ($query) use ($value) {
                    $query->where('real_name', '=', $value);
                });
                break;
            case 'phone':
                return PostPrize::whereHas('user_infos', function ($query) use ($key, $value) {
                    $query->where($key, '=', $value);
                });
                break;
            case 'mail_phone':
                return PostPrize::whereHas('user_addresses', function ($query) use ($key, $value) {
                    $query->where($key, '=', $value);
                });
                break;
            case 'shop_name':
                $users = User::where('shop_id', Shop::where('name', $value)->first()->id)->pluck('id');
                return PostPrize::whereIn('user_id', $users);
                break;
            case 'nickname':
                return PostPrize::whereHas('user_wechats', function ($query) use ($value) {
                    $query->where('nickname', 'like', "%$value%");
                });
                break;
            default :
                return PostPrize::where($key, $value);
        }
    }

    public function excel($key = null, $value = null)
    {
        //根据地区，返回店铺管理员
        Excel::create($value . '邮寄表' . date("Y-m-d"), function ($excel) use ($key, $value) {

            $excel->sheet('Sheetname', function ($sheet) use ($key, $value) {

                if ($key == null) {
                    $users = PostPrize::with('user_infos', 'user_wechats', 'users', 'user_addresses', 'user_attrs','qrcode_prizes')
                        ->get()
                        ->toArray();
                } else {
                    $users = $this->searchKey($key, $value)
                        ->with('user_infos', 'user_wechats', 'users', 'user_addresses', 'user_attrs','qrcode_prizes')
                        ->get()
                        ->toArray();
                }

                $data = [];

                $title = [
                    '用户编号',
                    '店铺编号',
                    '微信昵称',
                    '注册手机号',
                    '邮寄手机号',
                    '终端',
                    '奖品',
                    '省份',
                    '城市',
                    '县区',
                    '具体地址',
                    '创建时间',
                    '邮寄状态',
                ];

                foreach ($users as $user) {
                    array_push($data, [
                        $user['user_id'],
                        $shop_id = User::find($user['user_id'])->shop_id,
                        $user['user_wechats']['nickname'],
                        $user['user_infos']['phone'],
                        $user['user_addresses']['mail_phone'],
                        Shop::find($shop_id)->name,
                        $user['qrcode_prizes']['name'],
                        DB::table('mh_city')->find($user['user_addresses']['province'])->name,
                        DB::table('mh_city')->find($user['user_addresses']['city'])->name,
                        DB::table('mh_city')->find($user['user_addresses']['area'])->name,
                        $user['user_addresses']['address'],
                        $user['created_at'],
                        $user['status'],
                    ]);
                }

                $sheet->appendRow($title);
                $sheet->rows($data);
            });
        })->download('xls');

    }


    public function toggle($id)
    {
        $post = PostPrize::find($id);
        $post->status ? $post->status = 0:$post->status = 1;
        $post->save();
    }
}
