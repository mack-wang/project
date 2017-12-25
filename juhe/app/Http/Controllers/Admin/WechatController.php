<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\WechatRequest;
use App\WechatConfig;

class WechatController extends Controller
{
    public function index()
    {
        return view('admin.wechat', [
            'wechat' => WechatConfig::find(1),
        ]);
    }

    public function update(WechatRequest $request)
    {
        WechatConfig::find(1)->update($request->only('imgUrl','description','title','link'));
        return back()->with('success', '修改成功');
    }
}
