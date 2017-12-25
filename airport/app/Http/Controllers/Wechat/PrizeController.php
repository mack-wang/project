<?php

namespace App\Http\Controllers\Wechat;

use App\Models\PostPrize;
use App\Models\QrcodePath;
use App\Models\QrcodePrize;
use App\Models\Qrcodes;
use App\Models\ScanResult;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Vinkla\Hashids\Facades\Hashids;

class PrizeController extends Controller
{
    public function show()
    {

        if (Auth::guard('wechat')->user()->shop_id) {
            $prizes = QrcodePrize::where('type', 0)
                ->where('off', 0)
                ->paginate(4);
            return view('wechat.home.prize', [
                'prizes' => $prizes,
            ]);
        } else {
            return back()->with('error', '您未绑定任何店铺，暂时无法使用礼品券');

        }

    }

    public function prizeList()
    {

        $prizes = Qrcodes::with('shops', 'qrcode_paths', 'qrcode_prizes')
            ->where('user_id', session('user_id'))
            ->paginate(4);
        return view('wechat.home.prize-list', [
            'prizes' => $prizes,
        ]);

    }

    public function getPrize($id)
    {
        $prize = QrcodePrize::find($id);
        $user = User::with('user_infos')->find(session('user_id'));
        if ($prize->count === $prize->send_out) {
            return back()->with('error', '奖品已经兑换完了，请换一种奖品。');
        } else {

            if ($user->user_infos->ticket >= $prize->cost) {
                $user->user_infos()->decrement('ticket', $prize->cost);
            } else {
                return back()->with('error', '您的礼品券不足，无法兑换此奖品');
            }

            if ($user->shops->type === "airport") {
                PostPrize::create([
                    'user_id' => $user->id,
                    'prize_id' => $prize->id,
                ])->qrcode_prizes()
                    ->increment('send_out');
                return back()->with('success', '兑换成功,可到邮寄奖品处查看');
            } else {
                $result = Qrcodes::create([
                    'user_id' => $user->id,
                    'shop_id' => $user->shop_id,
                    'prize_id' => $id,
                    'state' => 0,
                    'start_at' => date("Y-m-d H:i:s"),
                    'end_at' => date("Y-m-d H:i:s", time() + $prize->expire),
                ]);

                $result->qrcode_prizes()->increment('send_out');

                $hash_qrcode_id = Hashids::encode($result->id);

                //创建日期文件夹，以免同一个文件夹下文件太多
                $date = date('Ymd');
                //生成日期文件夹
                $dir = public_path() . '/uploads/qrcode/' . $date . '/';
                //生成日期文件夹，因为Image这个拓展不能自动创建文件夹
                File::exists($dir) or File::makeDirectory($dir);

                QrCode::format('png')->size(300)->generate(Helper::url('/wechat/qrcode/scan', 0, $hash_qrcode_id), public_path('/uploads/qrcode/' . $date . '/' . $hash_qrcode_id . '.png'));

                QrcodePath::create([
                    'qrcode_id' => $result->id,
                    'qrcode_path' => '/uploads/qrcode/' . $date . '/' . $hash_qrcode_id . '.png',
                    'hashids' => $hash_qrcode_id,
                ]);

                return back()->with('success', '兑换成功,可到兑奖二维码处查看');
            }
        }
    }

    public function prize_qrcode($hashids)
    {
        $id = Hashids::decode($hashids)[0];
        $qrcode = Qrcodes::with('shops', 'qrcode_paths', 'qrcode_prizes')->find($id);
        return view('wechat.home.prize-qrcode', [
            'qrcode' => $qrcode,
        ]);
    }

    public function scan(Request $request)
    {
        $wechat = app('wechat');
        $result = $wechat->oauth->user();

        //当前二维码的信息
        $qrcode_id = Hashids::decode($request->state)[0];
        $qrcode = Qrcodes::with('shops')->find($qrcode_id);

        //当前扫码的管理员
        $manager = User::with('shop_managers')->where('openid', $result['id'])->first();

        if ($manager->shop_managers) {

            //判断是否是绑定店铺
            if ($qrcode->shop_id === $manager->shop_managers->shop_id) {
                //检查是否过期
                if (strtotime($qrcode->end_at) > time()) {
                    //检查是否已经兑过奖
                    if ($qrcode->state) {
                        Session::flash('success', '提示：二维码已经兑过奖了,不能重复兑奖');
                    } else {
                        $qrcode->state = 1;
                        $qrcode->save();
                        ScanResult::create([
                            'qrcode_id' => $qrcode_id,
                            'user_id' => $manager->id,
                        ]);

                        Session::flash('success', '兑奖成功！');
                    }
                } else {
                    Session::flash('error', '兑奖失败：兑奖二维码已经过期！');
                }
            } else {
                Session::flash('error', '兑奖失败：请到指定终端' . $qrcode->shops->name . '进行扫码');
            }
        } else {
            Session::flash('error', '兑奖失败：您不是管理员，不可以进行扫码核销兑奖！');
        }

        return view('wechat.home.scan');
    }

    public function showPostPrize()
    {
        $prizes = PostPrize::with('qrcode_prizes')
            ->where('user_id', session('user_id'))
            ->paginate(4);
        return view('wechat.home.post-prize-list', [
            'prizes' => $prizes,
        ]);
    }

}
