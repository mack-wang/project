<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Helper extends Controller
{
    public static function page()
    {
        return session('page')?session('page'):5;
    }

    public static function sendMessage($phone, $message)
    {
        $ch = curl_init();
        $post_data = array(
            "account" => "sdk_zjbyt",
            "password" => "20151116",
            "destmobile" => $phone,
            "msgText" => "【诚信有礼】".$message,
            "sendDateTime" => "",
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //这里原来是0，我改成1后，才能接收回调
        $post_data = http_build_query($post_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_URL, 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage');
        curl_exec($ch);

        //大于0就是发送成功，小于0就是发送失败
        return curl_multi_getcontent($ch); //接收上面的回调信息，是字符串
    }
}
