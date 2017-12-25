<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PrizeFormRequest;
use App\Models\QrcodePrize;
use App\Models\Qrcodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrizeController extends Controller
{
    public function show()
    {
        $prizes = QrcodePrize::paginate(8);
        return view('admin.prize', [
            'prizes' => $prizes,
        ]);
    }

    public function toggle($id)
    {
        $prize = QrcodePrize::find($id);
        $prize->off ? $prize->off = 0 : $prize->off = 1;
        $prize->save();
    }

    public function delete($id)
    {
        if (Qrcodes::where('prize_id', $id)->exists()) {
            return back()->with('error', '已经产生用户数据，不允许删除');
        } else {
            QrcodePrize::find($id)->delete();
            return back()->with('success', '删除成功');
        }
    }

    public function getPrize($id)
    {
        return QrcodePrize::find($id)->toJson();
    }

    public function form(prizeFormRequest $request)
    {
        QrcodePrize::updateOrCreate(
            $request->only('id'),
            $request->except('editorValue')
        );

        return back()->with('success', $request->id ? '修改成功' : '上传成功');
    }
}
