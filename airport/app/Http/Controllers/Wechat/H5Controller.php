<?php

namespace App\Http\Controllers\Wechat;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class H5Controller extends Controller
{
    //
    public function sandai()
    {
        $wechat = app('wechat');
        $js = $wechat->js;
        return view("wechat.h5.sandai")->with('js',$js);
    }
}
