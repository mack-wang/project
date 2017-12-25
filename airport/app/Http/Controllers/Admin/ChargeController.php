<?php

namespace App\Http\Controllers\Admin;

use App\Models\ResultChargeBuy;
use Illuminate\Http\Request;
use App\Models\PostPrize;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Fetch\Snoopy;

class ChargeController extends Controller
{
    //负责后台手机充值业务的显示
    public function index()
    {
        $balance = $this->queryBalance();
        $charged = round(ResultChargeBuy::whereHas('result_charge_callbacks', function ($query) {
            $query->where('status', '=', 2);
        })->sum("price")/1000,2);
        $users = PostPrize::with('user_infos', 'user_wechats', 'users', 'user_attrs', 'qrcode_prizes', 'result_charge_buys', 'result_charge_callbacks')
            ->paginate(Helper::page());
        return view('admin.charge', ['users' => $users, 'balance' => $balance, 'charged' => $charged]);
    }

    //根据搜索的参数，来显示所有用户
    public function search($key, $value)
    {
        //根据地区，返回所有用户
        $users = $this->searchKey($key, $value)
            ->with('user_infos', 'user_wechats', 'users', 'user_attrs', 'qrcode_prizes', 'result_charge_buys', 'result_charge_callbacks')
            ->paginate(Helper::page());

        return view('admin.charge', [
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
            case 'shop_name':
                $users = User::where('shop_id', Shop::where('name', $value)->first()->id)->pluck('id');
                return PostPrize::whereIn('user_id', $users);
                break;
            case 'nickname':
                return PostPrize::whereHas('user_wechats', function ($query) use ($value) {
                    $query->where('nickname', 'like', "%$value%");
                });
                break;
            case 'status':
                return PostPrize::whereHas('result_charge_callbacks', function ($query) use ($value) {
                    $query->where('status', $value);
                });
                break;
            default :
                return PostPrize::where($key, $value);
        }
    }

    public function excel($key = null, $value = null)
    {
        //根据地区，返回店铺管理员
        Excel::create($value . '话费充值记录表' . date("Y-m-d"), function ($excel) use ($key, $value) {

            $excel->sheet('Sheetname', function ($sheet) use ($key, $value) {

                if ($key == null) {
                    $users = PostPrize::with('user_infos', 'user_wechats', 'users', 'user_attrs', 'qrcode_prizes', 'result_charge_buys', 'result_charge_callbacks')
                        ->get()
                        ->toArray();
                } else {
                    $users = $this->searchKey($key, $value)
                        ->with('user_infos', 'user_wechats', 'users', 'user_attrs', 'qrcode_prizes', 'result_charge_buys', 'result_charge_callbacks')
                        ->get()
                        ->toArray();
                }

                $data = [];

                $title = [
                    '用户编号',
                    '店铺编号',
                    '微信昵称',
                    '真实姓名',
                    '手机号',
                    '终端',
                    '奖品',
                    '创建时间',
                    '订单号',
                    '交易号',
                    '流水号',
                    '充值金额（厘）',
                    '充值状态（2为成功3为失败）',
                ];

                foreach ($users as $user) {
                    array_push($data, [
                        $user['user_id'],
                        $shop_id = User::find($user['user_id'])->shop_id,
                        $user['user_wechats']['nickname'],
                        $user['user_attrs']['real_name'],
                        $user['user_infos']['phone'],
                        Shop::find($shop_id)->name,
                        $user['qrcode_prizes']['name'],
                        $user['created_at'],
                        $user['result_charge_buys']['serialno'],
                        $user['result_charge_callbacks']['bizId'],
                        $user['result_charge_callbacks']['ejId'],
                        $user['result_charge_buys']['price'],
                        $user['result_charge_callbacks']['status'],
                    ]);
                }

                $sheet->appendRow($title);
                $sheet->rows($data);
            });
        })->download('xls');

    }

    public function queryCharge($serialno)
    {
        $snoopy = new Snoopy;

        $url = "http://test.api2.adsl.cn/unicomAync/queryBizOrder.do?serialno=" . $serialno . "&userId=422&sign=" . md5($serialno . "422" . env("PHONE_CHARGE_PRIVATEKEY"));

        $snoopy->fetch($url);
        return simplexml_load_string($snoopy->results);
    }

    public function queryBalance()
    {
        $snoopy = new Snoopy;

        $url = "http://test.api2.adsl.cn/unicomAync/queryBalance.do?userId=422&sign=" . md5("422" . env("PHONE_CHARGE_PRIVATEKEY"));

        $snoopy->fetch($url);
        return round(simplexml_load_string($snoopy->results)->balance / 1000, 2);
    }
}
