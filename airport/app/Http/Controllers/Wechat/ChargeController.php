<?php

namespace App\Http\Controllers\Wechat;

use App\Fetch\Snoopy;
use App\Models\PostPrize;
use App\Models\QrcodePrize;
use App\Models\ResultChargeBuy;
use App\Models\ResultChargeCallback;
use App\Models\TestContent;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ChargeController extends Controller
{
    //负责给用户充值

    /*
     * 话费奖品，无论是机场的还是烟店的，都是邮寄奖品类型，所以都用post_prize的id作为奖品的流水号
     * */

    public function getPhoneCharge($post_prize_id)
    {
        $user_id = session('user_id');
        $post_prize = PostPrize::find($post_prize_id);

        if ($post_prize->status) {
            return back()->with('error', '您已经充值过');
        }

        $prize = QrcodePrize::find($post_prize->prize_id);

        if ($prize->kind == "charge") {
            if ($prize->price == 10) {
                $user = UserInfo::where('user_id', $user_id)->first();
                $this->phoneCharge($user->phone, 14159, $post_prize_id);
            }
            if ($prize->price == 3) {
                $user = UserInfo::where('user_id', $user_id)->first();
                $this->phoneCharge($user->phone, 14159, $post_prize_id);
            }
            return back();
        } else {
            return back()->with('error', '非法操作');
        }

    }

    public
    function phoneCharge($uid, $itemId, $serialno)
    {
        $snoopy = new Snoopy;
        $url = "http://test.api2.adsl.cn/unicomAync/buy.do";

        $vars["userId"] = 422;
        $vars["itemId"] = $itemId;
        $vars["uid"] = $uid;
        $vars["serialno"] = $serialno;
        $vars["dtCreate"] = date("YmdHms");
        $vars["sign"] = md5(
            $vars["dtCreate"]
            . $vars["itemId"]
            . $vars["serialno"]
            . $vars["uid"]
            . $vars["userId"]
            . env("PHONE_CHARGE_PRIVATEKEY")
        );

        $snoopy->fetch($url . "?" . http_build_query($vars));
        $result = simplexml_load_string($snoopy->results);
        if ($result->code == 0) {
            ResultChargeBuy::create([
                'amount' => $result->amount,
                'areaCode' => $result->areaCode,
                'bizOrderId' => $result->bizOrderId,
                'carrierType' => $result->carrierType,
                'itemFacePrice' => $result->itemFacePrice,
                'itemId' => $result->itemId,
                'itemName' => $result->itemName,
                'price' => $result->price,
                'serialno' => $result->serialno,
            ]);

            PostPrize::find($serialno)->update(['status' => 1]);
        }
        return $result->code;
    }

    public function callback(Request $request)
    {
        $sign = md5(
            $request->bizId
            . $request->downstreamSerialno
            . $request->ejId
            . $request->status
            . $request->userId
            . env("PHONE_CHARGE_PRIVATEKEY")
        );

        if ($sign == $request->sign) {
            ResultChargeCallback::create(
                $request->except('sign')
            );
        }

        PostPrize::find($request->downstreamSerialno)->update(['status' => 2]);

        return "success";
    }

    public function getItemId($phone,$price)
    {
        $snoopy = new Snoopy;
        $url = "http://api2.adsl.cn/api/v1/mobinfo.do?accesstoken=000001OBuve1xyqB000002XBuce2xywB000003XB2ce2xyXB&phone=".$phone;
        $snoopy->fetch($url);
        $result = explode("|",$snoopy->results);
        $type = $result[2];
        switch ($type.$price){
            case "移动20":
                $itemId = 17558;
                break;
            case "移动10":
                $itemId = 18125;
                break;
            case "移动5":
                $itemId = 18124;
                break;
            case "移动3":
                $itemId = 18841;
                break;
            case "联通20":
                $itemId = 17565;
                break;
            case "联通10":
                $itemId = 18127;
                break;
            case "联通5":
                $itemId = 18126;
                break;
            case "联通3":
                $itemId = 18837;
                break;
            case "电信20":
                $itemId = 17572;
                break;
            case "电信10":
                $itemId = 18129;
                break;
            case "电信5":
                $itemId = 18128;
                break;
            case "电信3":
                $itemId = 18839;
                break;
            default:
                $itemId = null;
        };

        return $itemId;
    }

}
