<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyFormRequest;
use App\UserCompany;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\Exception\Exception;

class CompanyController extends Controller
{
    //修改用户公司信息
    public function company(CompanyFormRequest $request)
    {
        $request->request->add(['user_id' => Auth::id()]);
        try {
            UserCompany::updateOrCreate(
                $request->only('id'),
                $request->only(
                    'user_id',
                    'company',
                    'size',
                    'industry'
                ));
            return back()->with('success', $request->id ? '修改公司信息成功' : '提交公司信息成功');
        } catch (Exception $e) {
            return back()->with('error', '编辑公司信息失败!')->withInput();
        }
    }

    public function show()
    {
        return view('wechat.company-info', [
            'company' => UserCompany::where('user_id', Auth::id())->first(),
        ]);
    }
}
