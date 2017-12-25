<?php

namespace App\Http\Controllers\Wechat;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressFormRequest;
use App\User;
use App\UserAddress;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\Exception\Exception;

class AddressController extends Controller
{
    //修改用户邮寄地址
    public function address(AddressFormRequest $request)
    {
        $request->request->add(['user_id' => Auth::id()]);
        try {
            UserAddress::updateOrCreate(
                $request->only('id'),
                $request->only(
                    'user_id',
                    'real_name',
                    'mail_phone',
                    'province',
                    'city',
                    'area',
                    'address'
                ));
            return back()->with('success', $request->id ? '修改邮寄信息成功' : '提交邮寄信息成功');
        } catch (Exception $e) {
            return back()->with('error', '编辑邮寄信息失败!')->withInput();
        }
    }

    public function show()
    {
        $address = UserAddress::where('user_id', Auth::id())->first();

        if ($address) {
            $address_str = City::find($address->province)->name
                . City::find($address->city)->name
                . City::find($address->area)->name
                . $address->address;
        } else {
            $address_str = null;

        }
        return view('wechat.address', ['address' => $address, 'address_str' => $address_str]);
    }

    //根据pid来返回城市名的json信息
    public function city($pid)
    {
        return City::where('pid', $pid)
            ->get(['id', 'name'])
            ->toJson();
    }

    public function getAddress($id)
    {
        return UserAddress::where('user_id', Auth::id())
            ->get(['id', 'real_name','mail_phone','province','city','area','address'])
            ->toJson();
    }

}
