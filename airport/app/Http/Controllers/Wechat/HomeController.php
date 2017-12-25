<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressFormRequest;
use App\Models\City;
use App\Models\ResultApply;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserAttr;
use MongoDB\Driver\Exception\Exception;
use Vinkla\Hashids\Facades\Hashids;


class HomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth.wechat');
    }

    public function index()
    {
        $id = session('user_id');
        $user = User::with('user_wechats')->find($id);
        $applies = ResultApply::with('activity_attrs')
            ->where('user_id', $id)
            ->take(2)
            ->get();

        $applyReports = ResultApply::with('reports', 'activity_attrs', 'activities')
            ->where('user_id', $id)
            ->where('status', 1)
            ->take(2)
            ->get();

        //生成用户邀请码
        $recommendCode = Hashids::connection('recommend')->encode($id);

        return view('wechat.home.home', [
            'user' => $user,
            'applies' => $applies,
            'applyReports' => $applyReports,
            'recommendCode' => $recommendCode,
        ]);
    }

    //修改用户邮寄地址
    public function address(AddressFormRequest $request)
    {
        $id = session('user_id');


        try {
            UserAttr::where('user_id', $id)->update([
                'real_name' => $request->real_name,
            ]);

            UserAddress::where('user_id', $id)->update($request->only([
                'mail_phone',
                'province',
                'city',
                'area',
                'address',
            ]));
            return back()->with('success', '修改邮寄信息成功');
        } catch (Exception $e) {
            return back()->with('error', '修改失败!')->withInput();
        }

    }

    public function view($blade)
    {
        $user = UserAddress::with('user_attrs')->where('user_id', session('user_id'))->first();
        $address = City::find($user->province)->name
            . City::find($user->city)->name
            . City::find($user->area)->name
            . $user->address;
        return view('wechat.home.' . $blade, ['user' => $user, 'address' => $address]);
    }

    public function applyList()
    {
        $applies = ResultApply::with('activity_attrs', 'activities')
            ->where('user_id', session('user_id'))
            ->paginate(4);

        return view('wechat.home.apply-list', [
            'applies' => $applies,
        ]);
    }

    public function reportList()
    {
        $applyReports = ResultApply::with('reports', 'activity_attrs', 'activities')
            ->where('user_id', session('user_id'))
            ->where('status', 1)
            ->paginate(4);

        return view('wechat.home.report-list', [
            'applyReports' => $applyReports,
        ]);
    }


}
