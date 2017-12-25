<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Lottery;
use App\Models\LotteryResult;
use App\Models\PostPrize;
use App\Models\QrcodePath;
use App\Models\QrcodePrize;
use App\Models\Qrcodes;
use App\Models\User;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Vinkla\Hashids\Facades\Hashids;

class LotteryController extends Controller
{
    public function index()
    {
        return view('wechat.lottery');
    }


    public function play()
    {
        $user = User::with('shops')->find(session('user_id'));
        //用户未绑定店铺，不需要抽奖
        if (!$user->shop_id) {
            return Response::json(['shop' => true]);
        }

        //判断用户是否已经抽过奖了，如果有需要的话，可以改成count()，让用户可以多抽奖几次
        $auth = LotteryResult::where('user_id', $user->id)->exists();
        if ($auth) {
            return Response::json(['auth' => $auth]);
        }

        $prizes = Lottery::all();
        $rand = mt_rand(1, 10000);
        $win_id = 0;
        $prize_id = 0;
        foreach ($prizes as $prize) {
            if ($rand >= $prize->start_num && $rand <= $prize->end_num) {
                $win_id = $prize->id;
                $prize_id = $prize->prize_id;
                break;
            }
        }

        $rand2 = mt_rand(0, 1);
        $offset = [3, 5][$rand2];
        $result = '谢谢参与';

        if ($win_id) {
            $prize = QrcodePrize::find($prize_id);
            //检查奖品是否送完
            $empty = ($prize->count == $prize->send_out);

            if (!$empty) {
                switch ($win_id) {
                    case 1:
                        $offset = 0;
                        break;
                    case 2:
                        $offset = 1;
                        break;
                    case 3:
                        $offset = 2;
                        break;
                    case 4:
                        $offset = 4;
                        break;
                }

                $result = $prize->name;

                //如果是机场用户，则全部用邮寄的方式
                if($user->shops->type === "airport"){
                    PostPrize::create([
                        'user_id'=>$user->id,
                        'prize_id'=>$prize_id,
                    ])->qrcode_prizes()
                    ->increment('send_out');
                }else{
                    $qrcode = Qrcodes::create([
                        'user_id' => $user->id,
                        'shop_id' => $user->shop_id,
                        'prize_id' => $prize_id,
                        'state' => 0,
                        'start_at' => date("Y-m-d H:i:s"),
                        'end_at' => date("Y-m-d H:i:s", time() + $prize->expire),
                    ]);

                    $qrcode->qrcode_prizes()->increment('send_out');

                    $hash_qrcode_id = Hashids::encode($qrcode->id);

                    //创建日期文件夹，以免同一个文件夹下文件太多
                    $date = date('Ymd');
                    //生成日期文件夹
                    $dir = public_path() . '/uploads/qrcode/' . $date . '/';
                    //生成日期文件夹，因为Image这个拓展不能自动创建文件夹
                    File::exists($dir) or File::makeDirectory($dir);

                    QrCode::format('png')->size(300)->generate(Helper::url('/wechat/qrcode/scan', 0, $hash_qrcode_id), public_path('/uploads/qrcode/' . $date . '/' . $hash_qrcode_id . '.png'));
                    QrcodePath::create([
                        'qrcode_id' => $qrcode->id,
                        'qrcode_path' => '/uploads/qrcode/' . $date . '/' . $hash_qrcode_id . '.png',
                        'hashids' => $hash_qrcode_id,
                    ]);
                }

            }
        }

        //抽奖结果表,如果是谢谢参与，则中奖的prize_id是0
        LotteryResult::create([
            'user_id' => $user->id,
            'prize_id' => $prize_id,
        ]);
        return Response::json(['offset' => $offset, 'result' => $result]);
    }

}
